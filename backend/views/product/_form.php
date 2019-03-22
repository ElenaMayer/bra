<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use \common\models\Product;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\Category;
use common\models\ProductSize;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoryArray(), ['prompt' => 'Выберите категорию ...']) ?>

    <?= $form->field($model, 'subcategories')->widget(DepDrop::classname(), [
        'data'=> Category::getSubcategoryArray($model->category_id),
        'options' => [
            'multiple' => true,
        ],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
            'depends'=>['product-category_id'],
            'url' => Url::to(['/product/get_subcategories']),
            'loadingText' => 'Загрузка ...',
            'tokenSeparators'=>[',',' '],
            'placeholder' => 'Выберите подкатегории ...',
        ],
    ]) ?>

    <?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 19]) ?>

    <?= $form->field($model, 'new_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_in_stock')->checkbox() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?= $form->field($model, 'color')->dropDownList(Yii::$app->params['colors'], ['prompt' => 'Выберите цвет ...']) ?>

    <?= $form->field($model, 'relationsArr')->widget(Select2::classname(), [
        'options' => [
            'multiple' => true,
            'placeholder' => Yii::t('app','Выберите связаные товары ...'),
        ],
        'data'=>Product::getProductArr(),
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators'=>[',',' '],
        ],
    ]) ?>

    <?= $form->field($model, 'size')->checkbox() ?>

    <div class="size-without-count" style="display: none">
        <?= $form->field($model, 'count')->textInput(['maxlength' => 19]) ?>
    </div>
    <div class="size-and-count">
        <fieldset>
            <legend>
                Размеры
                <?= Html::a('Добавить', 'javascript:void(0);', [
                    'id' => 'product-new-size-button',
                    'class' => 'pull-right btn btn-default btn-xs'
                ])?>
            </legend>
            <?php
                $size = new ProductSize();
                $size->loadDefaultValues(); ?>

            <table id="product-sizes" class="table table-condensed table-sizes">
                <thead>
                <tr>
                    <th><?=$size->getAttributeLabel('size')?></th>
                    <th><?=$size->getAttributeLabel('count')?></th>
                    <td>&nbsp;</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model->sizes as $key => $_size):?>
                    <tr>
                        <?= $this->render('_form-size', [
                            'key' => $_size->isNewRecord ? (strpos($key, 'new') !== false ? $key : 'new' . $key) : $_size->id,
                            'form' => $form,
                            'size' => $_size,
                        ]);?>
                    </tr>
                <?php endforeach;?>

                <tr id="product-new-size-block" style="display: none;">
                    <?= $this->render('_form-size', [
                        'key' => '__id__',
                        'form' => $form,
                        'size' => $size,
                    ]);?>
                </tr>
                </tbody>
            </table>

            <?php ob_start(); // output buffer the javascript to register later ?>
            <script>
                var size_k = <?php echo isset($key) ? str_replace('new', '', $key) : 0; ?>;
                $('#product-new-size-button').on('click', function () {
                    size_k += 1;
                    $('#product-sizes').find('tbody')
                        .append('<tr>' + $('#product-new-size-block').html().replace(/__id__/g, 'new' + size_k) + '</tr>');

                });

                $(document).on('click', '.product-remove-size-button', function () {
                    $(this).closest('tbody tr').remove();
                });

                <?php
                // OPTIONAL: click add when the form first loads to display the first new row
                if (!Yii::$app->request->isPost && $model->isNewRecord)
                    echo "$('#product-new-size-button').click();";
                ?>

            </script>
            <?php $this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean())); ?>

        </fieldset>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
