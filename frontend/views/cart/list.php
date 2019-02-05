<?php
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
$this->title = 'Корзина';
?>
<!-- Page Title -->
<section class="page-title text-center">
    <div class="container relative clearfix">
        <div class="title-holder">
            <div class="title-text">
                <h1 class="uppercase">Корзина</h1>
            </div>
        </div>
    </div>
</section> <!-- end page title -->

<section class="section-wrap shopping-cart pt-0">
    <div class="container relative">
        <div class="row">
            <div class="col-md-12">
                <div class="table-wrap mb-30">
                    <table class="shop_table cart table">
                        <thead>
                        <tr>
                            <th class="product-name" colspan="2"></th>
                            <th class="product-price">Цена</th>
                            <th class="product-quantity">Количество</th>
                            <th class="product-subtotal">Всего</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product):?>
                                <?php if($product->getIsActive()):?>
                                    <?php $quantity = $product->getQuantity(); ?>
                                    <tr class="cart_item <?php if(!$product->getIsInStock()):?>out_of_stock<?php endif;?>">
                                        <td class="product-thumbnail">
                                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                                <?= Html::img($product->images[0]->getUrl('small'), ['width' => '100', 'height' => '100', 'alt'=>$product->title]);?>
                                            </a>
                                        </td>
                                        <td class="product-name">
                                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>"><?= $product->title ?></a>
                                            <ul>
                                                <li>Размер: <?= $product->size ?></li>
                                                <li>Цвет: <?= $product->color ?></li>
                                            </ul>
                                        </td>
                                        <td class="product-price">
                                            <span class="amount"><?= $product->new_price ? $product->new_price : (int)$product->price ?><i class="fa fa-ruble"></i></span>
                                        </td>
                                        <td class="product-quantity">
                                            <div class="quantity buttons_added">
                                                <input type="button" value="-" class="minus" /><input type="number" step="1" min="0" value="<?= $quantity ?>" title="Qty" class="input-text qty text" /><input type="button" value="+" class="plus">
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount"><?= $product->getCost() ?><i class="fa fa-ruble"></i></span>
                                        </td>
                                        <td class="product-remove">
                                            <a data-id="<?= $product->id ?>" id="remove_cart_item" class="remove"  title="Удалить">
                                                <i class="icon icon_close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mb-50">
                    <div class="col-md-5 col-sm-12"></div>

                    <div class="col-md-7">
                        <div class="actions right">
                            <div class="wc-proceed-to-checkout">
                                <a href="/cart/order" class="btn btn-md btn-color"><span>Оформить заказ</span></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- end col -->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-md-6 shipping-calculator-form"></div> <!-- end col shipping calculator -->

            <div class="col-md-4 col-md-offset-2">
                <div class="cart_totals">
                    <h2 class="heading relative heading-small uppercase mb-30">Итого</h2>

                    <table class="table shop_table">
                        <tbody>
                        <tr class="cart-subtotal">
                            <th>Подитог</th>
                            <td>
                                <span class="amount"><?= $cart->getCost()?><i class="fa fa-ruble"></i></span>
                            </td>
                        </tr>
                        <tr class="shipping">
                            <th>Доставка</th>
                            <td>
                                <span>Free Shipping</span>
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

                </div>
            </div> <!-- end col cart totals -->

        </div> <!-- end row -->


    </div> <!-- end container -->
</section> <!-- end cart -->