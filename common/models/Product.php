<?php

namespace common\models;

use frontend\models\Wishlist;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\behaviors\SluggableBehavior;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;
use yii\web\UploadedFile;
use Imagine\Image\Box;
use yii\helpers\ArrayHelper;
use Imagine\Image\Point;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property integer $category_id
 * @property integer $price
 * @property string $article
 * @property integer $is_in_stock
 * @property integer $is_active
 * @property integer $is_novelty
 * @property string $size
 * @property string $color
 * @property string $tags
 * @property integer $new_price
 * @property integer $count
 * @property double $weight
 * @property string $time
 * @property string $subcategories
 *
 * @property Image[] $images
 * @property OrderItem[] $orderItems
 * @property Category $category
 * @property ProductRelation[] $relations
 * @property ProductSize[] $sizes
 */
class Product extends \yii\db\ActiveRecord implements CartPositionInterface
{
    use CartPositionTrait;

    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public $relationsArr;
    public $_productSizes;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['category_id', 'is_in_stock', 'is_active', 'is_novelty', 'new_price', 'count', 'price'], 'integer'],
            ['weight', 'match', 'pattern' => '/^[0-9]+[0-9,.]*$/', 'message' => 'Значение должно быть числом.'],
            [['title', 'article', 'category_id', 'price', 'color'], 'required'],
            [['time, size, tags, subcategories'], 'safe'],
            [['slug', 'article'], 'string', 'max' => 255],
            [['title', 'color'], 'string', 'max' => 40],
            [['article'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Названи',
            'slug' => 'Slug',
            'description' => 'Описание',
            'category_id' => 'Категория',
            'subcategories' => 'Подкатегория',
            'price' => 'Цена',
            'article' => 'Артикул',
            'is_in_stock' => 'В наличии',
            'is_active' => 'Показывать',
            'is_novelty' => 'Новинка',
            'size' => 'Размер',
            'color' => 'Цвет',
            'tags' => 'Теги',
            'new_price' => 'Цена со скидкой',
            'count' => 'Количество',
            'weight' => 'Вес, кг',
            'time' => 'Дата создания',
            'imageFiles' => 'Фото',
            'relationsArr' => 'Связанные товары',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $key=>$file) {
                $image = new Image();
                $image->product_id = $this->id;
                if ($image->save()) {
                    $file->saveAs($image->getPath('origin'));
                    $this->prepareImage($image);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    private function prepareImage($image){
        $wR = Yii::$app->params['productBigImageWidth'];
        $hR = Yii::$app->params['productBigImageHeight'];
        $i = \yii\imagine\Image::getImagine()
            ->open($image->getPath('origin'))
            ->thumbnail(new Box($wR, $hR), ManipulatorInterface::THUMBNAIL_OUTBOUND);
        $size = $i->getSize();
        $wC = $size->getWidth();
        $hC = $size->getHeight();

        // Current img < result img
        if($wR > $wC && $hR > $hC){
            if($hC > $wC && ($hC/$wC > $hR/$wR)){
                $this->cropHeight($i, $wC, $hC, $wR, $hR);
            } elseif ($hC <= $wC || $hC/$wC < $hR/$wR){
                $this->cropWidth($i, $wC, $hC, $wR, $hR);
            }
        } elseif ($wR > $wC) {
            $this->cropHeight($i, $wC, $hC, $wR, $hR);
        } elseif ($hR > $hC){
            $this->cropWidth($i, $wC, $hC, $wR, $hR);
        }

        $i->save($image->getPath('big', ['quality' => 80]))
            ->thumbnail(new Box(Yii::$app->params['productMediumImageWidth'], Yii::$app->params['productMediumImageHeight']))
            ->save($image->getPath('medium', ['quality' => 80]))
            ->thumbnail(new Box(Yii::$app->params['productSmallImageWidth'], Yii::$app->params['productSmallImageHeight']))
            ->save($image->getPath('small', ['quality' => 80]));
    }

    private function cropWidth(&$i, $wC, $hC, $wR, $hR){
        $wNew = $wR*$hC/$hR;
        $i->crop(new Point(($wC-$wNew)/2, 0), new Box($wNew, $hC));
    }

    private function cropHeight(&$i, $wC, $hC, $wR, $hR){
        $hNew = $wC*$hR/$wR;
        $i->crop(new Point(0, ($hC - $hNew)/2), new Box($wC, $hNew));
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['product_id' => 'id']);
    }

    /**
     * @return ProductRelation[]
     */
    public function getRelations()
    {
        return $this->hasMany(ProductRelation::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ProductSize[]
     */
    public function getSizes()
    {
        return $this->hasMany(ProductSize::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function isInWishlist()
    {
        if (!Yii::$app->user->isGuest) {
            $wishlist = Wishlist::find()
                ->where(['user_id' => Yii::$app->user->id, 'product_id' => $this->id])
                ->one();
            if ($wishlist)
                return true;
            else
                return false;
        } else
            return false;
    }

    /**
     * @inheritdoc
     */
    public function getPrice($orderCreated = false)
    {
        if (($this->getIsActive() && $this->getIsInStock()) || $orderCreated){
            if($this->getNewPrice())
                return $this->getNewPrice();
            else
                return $this->price;
        } else {
            return 0;
        }
    }

    public function getIsActive()
    {
        $product = Product::findOne($this->id);
        return $product->is_active;
    }

    public function getIsInStock()
    {
        $product = Product::findOne($this->id);
        if($product->is_in_stock){
            if(!$this->size){
                if ($this->count > 0){
                    return true;
                } else {
                    return false;
                }
            } else {
                foreach ($this->sizes as $size){
                    if($size->count > 0)
                    return true;
                }
                return false;
            }
        } else
            return false;
    }

    public function getCount()
    {
        $product = Product::findOne($this->id);
        return $product->count;
    }

    public function getNewPrice()
    {
        $product = Product::findOne($this->id);
        return $product->new_price;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    public static function getAllSizesArray($categoryId = null)
    {
        $sizes = [];
        if($categoryId) {
            $models = Product::find()
                ->select(['{{product_size}}.size'])
                ->joinWith('sizes')
                ->where(['or', ['category_id' => $categoryId], ['subcategories' => $categoryId]])
                ->andWhere(['>', '{{product_size}}.count', 0])
                ->distinct()
                ->all();
            foreach ($models as $model) {
                $sizes[$model->size] = $model->size;
            }
        } else {
            $models = ProductSize::find()->distinct()->all();
            $sizes = ArrayHelper::map($models, 'size', 'size');
        }
        asort($sizes);
        return $sizes;
    }

    public function getSizesArray()
    {
        $sizes = [];
        foreach ($this->sizes as $size) {
            if($size->count > 0)
                $sizes[$size->id] = $size->size;
        }
        return $sizes;
    }

    public static function getAllColorsArray($categoryId = null)
    {
        $models = Product::find();
        if($categoryId) {
            $models = $models->where(['or', ['category_id' => $categoryId], ['subcategories' => $categoryId]]);
        }
        $models = $models->all();
        $colors = [];
        $colorsArr = Yii::$app->params['colors'];
        foreach ($models as $m)
        {
            if ($m->color && !in_array($m->color, $colors)) {
                $colors[$m->color] = isset($colorsArr[$m->color]) ? $colorsArr[$m->color] : $m->color;
            }
        }
        asort($colors);
        return $colors;
    }

    public function getProductColors()
    {
        $colors = [
            $this->color => [
                'title' => Yii::$app->params['colors'][$this->color]
            ]
        ];
        if($this->relations){
            foreach ($this->relations as $relation)
            {
                $cc = $relation->child->color;
                $colors[$cc] = [
                    'title' => Yii::$app->params['colors'][$cc],
                    'id' => $relation->child_id,
                ];
            }
        }
        return $colors;
    }

    public static function getTagsArray($is_active = null)
    {
        $models = Product::find();
        if($is_active)
            $models = $models->where(['is_active' => $is_active]);
        $models = $models->all();
        $tags = [];
        foreach ($models as $m)
        {
            $ts = explode(",",$m->tags);
            foreach ($ts as $t)
            {
                if ($t && !in_array($t,$tags))
                {
                    $tags[$t] = $t;
                }
            }
        }
        return $tags;
    }

    public function getCurrentTagsArray()
    {
        $tags = [];
        $ts = explode(",", $this->tags);
        foreach ($ts as $t)
        {
            if (!in_array($t,$tags))
            {
                $tags[$t] = $t;
            }
        }
        return $tags;
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->relationsArr = ArrayHelper::map($this->relations, 'id', 'child_id');
    }

    public function minusCount($count, $size){

        if($this->size && $size){
            $productSize = ProductSize::find()
                ->where(['product_id' => $this->id, 'size' => $size])
                ->one();
            if($productSize) {
                $productSize->count -= $count;
                $productSize->save();
            }
        } else {
            $this->count -= $count;
            if ($this->count <= 0) {
                $this->is_in_stock = 0;
            }
            $this->save(false);
        }
    }

    public function plusCount($count, $size){
        if($this->size && $size){
            $productSize = ProductSize::find()
                ->where(['product_id' => $this->id, 'size' => $size])
                ->one();
            if($productSize) {
                $productSize->count += $count;
                $productSize->save();
            }
        } else {
            $this->count += $count;
            if ($this->count > 0) {
                $this->is_in_stock = 1;
            }
            $this->save(false);
        }
    }

    public function getSale(){
        if($this->price && $this->new_price){
            return round(100 - ($this->new_price * 100 / $this->price));
        } else {
            return 0;
        }
    }

    public static function getNovelties($count = 4){
        $noveltyProducts = Product::find()
            ->where(['is_active' => 1, 'is_in_stock' => 1])
            ->limit($count)
            ->orderBy('id DESC')
            ->all();
        return $noveltyProducts;
    }

    public function getActiveRelations()
    {
        $result = [];
        foreach (array_values($this->relations) as $index => $model){
            if($model->child->getIsActive() && $model->child->getIsInStock()){
                $result[] = $model;
            }
        }
        return $result;
    }

    public static function getProductArr()
    {
        $model = Product::find()
            ->select(['*', 'CONCAT(article, \' - \', title) as description']);

        $model = $model->all();
        return ArrayHelper::map($model, 'id', 'description');
    }

    public function getProductSizes()
    {
        if ($this->_productSizes === null) {
            $this->_productSizes = $this->isNewRecord ? [] : $this->sizes;
        }
        return $this->_productSizes;
    }

    private function getProductSize($key)
    {
        $size = $key && strpos($key, 'new') === false ? ProductSize::findOne($key) : false;
        if (!$size) {
            $size = new ProductSize();
            $size->loadDefaultValues();
        }
        return $size;
    }

    public function setProductSizes($sizes)
    {
        unset($sizes['__id__']); // remove the hidden "new ProductSize" row
        $this->_productSizes = [];
        foreach ($sizes as $key => $size) {
            if (is_array($size)) {
                $this->_productSizes[$key] = $this->getProductSize($key);
                $this->_productSizes[$key]->setAttributes($size);
            } elseif ($size instanceof ProductSize) {
                $this->_productSizes[$size->id] = $size;
            }
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if(!$this->productSizes){
                $this->size = 0;
            }
//            $this->weight = str_replace(',', '.', $this->weight);
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $this->saveSizes();
    }

    public function saveRelations($relations)
    {
        if ($this->relations) {
            foreach ($this->relations as $relation) {
                $relation->delete();
            }
        }
        foreach ($relations as $relationId) {
            $relation = new ProductRelation();
            $relation->parent_id = $this->id;
            $relation->child_id = $relationId;
            $relation->save();

            $relation = new ProductRelation();
            $relation->parent_id = $relationId;
            $relation->child_id = $this->id;
            $relation->save();
        }
    }

    public function saveSizes()
    {
        $keep = [];
        foreach ($this->productSizes as $size) {
            if($size->size) {
                $size->product_id = $this->id;
                if (!$size->save(false)) {
                    return false;
                }
                $keep[] = $size->id;
            }
        }
        $query = ProductSize::find()->andWhere(['product_id' => $this->id]);
        if ($keep) {
            $query->andWhere(['not in', 'id', $keep]);
        }
        foreach ($query->all() as $size) {
            $size->delete();
        }
        return true;
    }

    public function getSubcategory()
    {
        preg_match('/^[0-9]+,|^[0-9]+$/', $this->subcategories, $subcatId);
        if(!empty($subcatId))
            return Category::findOne(trim($subcatId[0], ','));
        else
            return null;
    }

    public function getCartPosition($params = [])
    {
        return Yii::createObject([
            'class' => 'frontend\models\ProductCartPosition',
            'id' => $this->id,
        ]);
    }

    public function getProductSizesStr(){
        $result = '';
        foreach ($this->sizes as $size){
            $result .= $size->size . ', ';
        }
        return trim(trim($result), ',');
    }

    public function getItemCount($size){
        if($size) {
            $productSize = ProductSize::findOne([
                'product_id' => $this->id,
                'size' => $size,
            ]);
            $count = $productSize->count;
        } else {
            $count = $this->count;
        }
        return $count;
    }

    public function getProductSizesArr()
    {
        $result = [];
        foreach ($this->sizes as $size){
            $result[$size] = $size;
        }
        return $result;
    }
}
