<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Order;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList(Order::getStatuses()) ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'shipping_method')->dropDownList(Order::getShippingMethods()) ?>

    <div class="form-group shipping_method_field method_rp" <?php if($model->shipping_method != 'rp'):?>style="display: none"<?php endif;?>">
        <?= $form->field($model, 'zip')->textInput(['maxlength' => 6]) ?>
    </div>

    <div class="form-group shipping_method_field method_courier" <?php if($model->shipping_method != 'courier'):?>style="display: none"<?php endif;?>">
        <?= $form->field($model, 'is_try_on')->checkbox() ?>
        <?= $form->field($model, 'shipping_area')->dropDownList(Order::getShippingAreaBase()) ?>
    </div>

    <div class="form-group shipping_method_field method_rp method_courier" <?php if($model->shipping_method != 'rp'):?>style="display: none"<?php endif;?>">
        <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>
    </div>

    <div class="form-group shipping_method_field method_tk" <?php if($model->shipping_method != 'tk'):?>style="display: none"<?php endif;?>">
        <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>
    </div>

    <?= $form->field($model, 'shipping_cost')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'payment_method')->dropDownList(Order::getPaymentMethods()) ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
