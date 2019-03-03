<?php
use \yii\helpers\Html;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $products common\models\Product[] */
$this->title = 'Корзина';

$cart = \Yii::$app->cart;
$positions = $cart->getPositions();
$activeItemsInCart = $cart->getActiveCount();
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

<?php if($cart->getCount() == 0):?>
<section class="section-wrap shopping-cart pt-0">
    <div class="container relative">
        <div class="row mb-50">
            <div class="col-md-5 col-sm-12">Ваша корзина в данный момент пуста.</div>
            <div class="col-md-7">
                <div class="actions right">
                    <div class="wc-proceed-to-checkout">
                        <a href="/catalog/<?= Category::find()->one()->slug?>" class="btn btn-md btn-color"><span>Продолжить покупки</span></a>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end cart -->
<?php else:?>
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
                                <?php foreach ($positions as $position):?>
                                <?php $product = $position->getProduct();?>
                                    <?php if($product->getIsActive()):?>
                                        <?php $quantity = $position->getQuantity(); ?>
                                        <tr class="cart_item <?php if(!$product->getIsInStock()):?>disabled<?php endif;?>">
                                            <td class="product-thumbnail">
                                                <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                                    <?= Html::img($product->images[0]->getUrl('small'), ['width' => '100', 'height' => '100', 'alt'=>$product->title]);?>
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>"><?= $product->title ?></a>
                                                <?php if($product->getIsInStock()):?>
                                                    <?php if($position->size):?>
                                                        <ul>
                                                            <li>Размер: <?= $position->size ?></li>
                                                        </ul>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <p>Нет в наличии</p>
                                                <?php endif;?>
                                            </td>
                                            <td class="product-price">
                                                <span class="price">
                                                    <?php if($product->getIsInStock() && $product->new_price):?>
                                                        <del>
                                                            <span><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                                                        </del>
                                                        <ins>
                                                            <span class="ammount sale"><?= $product->new_price?><i class="fa fa-ruble"></i></span>
                                                        </ins>
                                                    <?php else:?>
                                                        <ins>
                                                            <span class="ammount"><?= (int)$product->price?><i class="fa fa-ruble"></i></span>
                                                        </ins>
                                                    <?php endif;?>
                                                </span>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="quantity buttons_added">
                                                    <form>
                                                        <?php if($product->getIsInStock()):?>
                                                            <input type="button" value="-" class="minus cart-qty" />
                                                            <input type="number" name="quantity" step="1" min="1" value="<?= $quantity ?>" title="Количество" class="input-text qty text" />
                                                            <input type="button" value="+" class="plus cart-qty">
                                                            <input type="hidden" name="id" value="<?=$position->getId()?>">
                                                        <?php else:?>
                                                            <input type="number" name="quantity" value="0" title="Количество" class="input-text qty text" />
                                                        <?php endif;?>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="amount"><span id="amount_val_<?= $position->getId() ?>"><?= $position->getCost() ?></span><i class="fa fa-ruble"></i></span>
                                            </td>
                                            <td class="product-remove">
                                                <a data-id="<?= $position->getId() ?>" id="remove_cart_item" class="remove"  title="Удалить">
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
                        <?php if($activeItemsInCart > 0):?>
                            <div class="col-md-7">
                                <div class="actions right">
                                    <div class="wc-proceed-to-checkout">
                                        <a href="/cart/order" class="btn btn-md btn-color"><span>Оформить заказ</span></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-md-6 shipping-calculator-form">
    <!--                <h2 class="heading relative heading-small uppercase mb-30">Расчет стоимости доставки</h2>-->
    <!--                <p class="form-row form-row-wide">-->
    <!--                    <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">-->
    <!--                        --><?php //foreach (Order::getShippingMethods() as $key => $method):?>
    <!--                            <option value="--><?//=$key?><!--">--><?//=$method?><!--</option>-->
    <!--                        --><?php //endforeach;?>
    <!--                    </select>-->
    <!--                </p>-->
    <!--                <div class="row row-20 shipping_methods">-->
    <!--                    <div class="col-sm-6">-->
    <!--                        <p class="form-row form-row-wide">-->
    <!--                            <input type="text" class="input-text" value placeholder="Город" name="calc_shipping_state" id="calc_shipping_state">-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                    <div class="col-sm-6">-->
    <!--                        <p class="form-row form-row-wide">-->
    <!--                            <input type="text" class="input-text" value placeholder="Индекс" name="calc_shipping_postcode" id="calc_shipping_postcode">-->
    <!--                        </p>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!---->
    <!--                <p>-->
    <!--                    <button type="submit" name="calc_shipping" value="1" class="btn btn-md btn-dark mt-20 mb-mdm-40">Считать</button>-->
    <!--                </p>-->
                </div> <!-- end col shipping calculator -->

                <div id="cart-total" class="col-md-4 col-md-offset-2">
                    <?= $this->render('_total'); ?>
                </div>
            </div> <!-- end row -->


        </div> <!-- end container -->
    </section> <!-- end cart -->
<?php endif;?>