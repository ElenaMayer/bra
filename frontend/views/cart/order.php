<?php
use \yii\bootstrap\ActiveForm;
use common\models\Order;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
$this->title = 'Оформление заказа';
?>
<!-- Page Title -->
<section class="page-title text-center">
    <div class="container relative clearfix">
        <div class="title-holder">
            <div class="title-text">
                <h1 class="uppercase">Оформление заказа</h1>
            </div>
        </div>
    </div>
</section> <!-- end page title -->

<!-- Checkout -->
<section class="section-wrap checkout pt-0 pb-50">
    <div class="container relative">
        <div class="row">

            <div class="ecommerce col-xs-12">

                <?php
                /* @var $form ActiveForm */
                $form = ActiveForm::begin([
                    'id' => 'order-form',
                    'class' => 'checkout ecommerce-checkout row',
                ]);?>

                    <div class="col-md-8" id="customer_details">
                        <div>
                            <h2 class="heading uppercase mb-30">Адрес</h2>

                                <?= $form->field($order, 'fio')->textInput(['placeholder' => 'Фамилия Имя Отчество', 'class' => 'input-text']); ?>
                                <?= $form->field($order, 'phone')->textInput(['placeholder' => '+7777-777-7777', 'class' => 'input-text']); ?>
                                <?= $form->field($order, 'email')->textInput(['placeholder' => 'example@mail.ru', 'class' => 'input-text']); ?>

                            <?= $form->field($order, 'shipping_method')->dropDownList(Order::getShippingMethods(), ['class' => 'country_to_state country_select']); ?>

                            <div class="shipping_methods">
                                <div class="rp" style="display: none">
                                    <?= $form->field($order, 'zip')->textInput(['placeholder' => '630000', 'class' => 'form-control dark', 'maxlength' => 6]); ?>
                                    <?= $form->field($order, 'address')->textInput(['placeholder' => 'Новосибирск, ул.Ленина д.1 кв.1', 'class' => 'form-control dark']); ?>
                                </div>
                                <div class="tk" style="display: none">
                                    <?= $form->field($order, 'city')->textInput(['class' => 'form-control dark']); ?>
                                </div>
                            </div>
                            <div class="clear"></div>

                        </div>

                        <div class="clear"></div>

                        <?= $form->field($order, 'notes')->textarea(['class' => 'input-text', 'rows' => "2", 'cols' => "5"]); ?>

                        <div class="clear"></div>

                    </div> <!-- end col -->


                    <div class="col-md-4">
                        <div class="order-review-wrap ecommerce-checkout-review-order" id="order_review">
                            <h2 class="heading uppercase mb-30">Заказ</h2>
                            <table class="table shop_table ecommerce-checkout-review-order-table">
                                <tbody>
                                <?php foreach ($positions as $position):?>
                                <?php $product = $position->getProduct();?>
                                    <?php if($product->getIsActive() && $product->getIsInStock()):?>
                                        <tr>
                                            <th><?= $product->title?> <?= $position->size?><span class="count"> x <?= $position->getQuantity()?></span></th>
                                            <td>
                                                <span class="amount"><?= (int)$position->getCost()?><i class="fa fa-ruble"></i></span>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach ?>
                                <tr class="cart-subtotal">
                                    <th>Подитог</th>
                                    <td>
                                        <span class="amount"><?= $cart->getCost()?><i class="fa fa-ruble"></i></span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>Доставка</th>
                                    <td>
                                        <span>Бесплатно</span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th><strong>Итого</strong></th>
                                    <td>
                                        <strong><span class="amount"><?= $cart->getCost()?><i class="fa fa-ruble"></i></span></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div id="payment" class="ecommerce-checkout-payment">
                                <h2 class="heading uppercase mb-30">Способ оплаты</h2>
                                <ul class="payment_methods methods">
                                    <?php foreach (Order::getPaymentMethods() as $key=>$value):?>
                                        <li class="payment_method_<?=$key?>">
                                            <input id="payment_method_<?=$key?>" type="radio" class="input-radio" name="Order[payment_method]" value="<?=$key?>" checked>
                                            <label for="payment_method_<?=$key?>"><?=$value?></label>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                                <div class="form-row place-order">
                                    <?= Html::submitInput('Отправить заказ', ['class' => 'checkout-button btn btn-lg']) ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end order review -->
                <?php ActiveForm::end() ?>
            </div> <!-- end ecommerce -->
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end checkout -->
