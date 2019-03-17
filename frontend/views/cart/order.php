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
                            <div class="order-try-on" style="display: none">
                                <a href="/tryon" target="_blank">Оснакомьтесь с условиями примерки</a>
                                <div class="pb-20"></div>
                            </div>
                            <div class="shipping_methods">
                                <div class="rp" style="display: none">
                                    <div class="col-sm-3">
                                        <?= $form->field($order, 'zip')->textInput(['placeholder' => '630000', 'class' => 'form-control dark', 'maxlength' => 6]); ?>
                                    </div>
                                    <div class="col-sm-9">
                                        <?= $form->field($order, 'address')->textInput(['placeholder' => 'Москва, ул.Ленина д.1 кв.1', 'class' => 'form-control dark']); ?>
                                    </div>
                                </div>
                                <div class="tk" style="display: none">
                                    <?= $form->field($order, 'city')->textInput(['placeholder' => 'Москва, ул.Ленина д.1', 'class' => 'form-control dark']); ?>
                                </div>
                                <div class="courier" style="display: none">
                                    <?= $form->field($order, 'address')->textInput(['placeholder' => 'ул.Ленина д.1 кв.1', 'class' => 'form-control dark']); ?>
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
                                        <span class="amount subtotal"><span><?= $cart->getCost()?></span><i class="fa fa-ruble"></i></span>
                                    </td>
                                </tr>
                                <tr class="shipping">
                                    <th>Доставка</th>
                                    <td>
                                        <span class="shipping-cost">0<i class="fa fa-ruble"></i></span>
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th><strong>Итого</strong></th>
                                    <td>
                                        <strong><span class="amount total"><span><?= $cart->getCost()?></span><i class="fa fa-ruble"></i></span></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div id="payment" class="ecommerce-checkout-payment">
                                <h2 class="heading uppercase mb-30">Способ оплаты</h2>
                                <ul class="payment_methods methods" id="order-payment_method">
                                    <li class="payment_method_cash">
                                        <input id="payment_method_cash" type="radio" class="input-radio" name="Order[payment_method]" value="cash" checked>
                                        <label for="payment_method_cash">Наличными при получении</label>
                                        <div class="payment_box payment_method_bacs">
                                            <p></p>
                                        </div>
                                    </li>
                                    <li class="payment_method_card">
                                        <input id="payment_method_card" type="radio" class="input-radio" name="Order[payment_method]" value="card">
                                        <label for="payment_method_card">На карту</label>
                                        <img src="/img/carts.png" alt="Carts">
                                        <div class="payment_box payment_method_cart">
                                            <p>Вы будете перенаправлены на платежный шлюз ОАО "Сбербанк России", где Вы сможете указать реквизиты Вашей банковской карты. Соединение с платежным шлюзом и передача параметров Вашей пластиковой карты осуществляется в защищенном режиме с использованием 128-битного протокола шифрования SSL.</p>
                                        </div>
                                    </li>
                                </ul>
                                <div class="offer">Нажимая кнопку "Отправить заказ" Вы соглашаетесь с <a href="/offer">Политикой конфиденциальности</a></div>
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
