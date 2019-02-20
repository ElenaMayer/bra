<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property integer $product_id
 *
 * @property Product $product
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getPath($size = 'big')
    {
        return Yii::getAlias('@frontend/web/uploads/product/' . $this->product_id . '_' . $this->id . '_' . $size . '.jpg');
    }

    public function getUrl($size = 'big')
    {
        return Yii::getAlias('@frontendWebroot/uploads/product/' . $this->product_id . '_' . $this->id . '_' . $size . '.jpg');
    }

    public function afterDelete()
    {
        unlink($this->getPath('small'));
        unlink($this->getPath('medium'));
        unlink($this->getPath('big'));
        parent::afterDelete();
    }
}