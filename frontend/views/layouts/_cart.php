<?php
use yii\helpers\Html;

$cart = Yii::$app->cart;
$itemsInCart = $cart->getCount();
$activeItemsInCart = $cart->getActiveCount();
?>
<div class="nav-cart right">
    <div class="nav-cart-outer">
        <div class="nav-cart-inner">
            <a <?php if($itemsInCart):?>href="/cart"<?php endif;?> class="nav-cart-icon"><?=$activeItemsInCart ? $activeItemsInCart : 0?></a>
        </div>
    </div>
    <?php if($itemsInCart > 0 && $itemsInCart < 4):?>
        <div class="nav-cart-container">
            <div class="nav-cart-items">
                <?php $positions = $cart->getPositions(); ?>
                <?php foreach ($cart->getPositions() as $positions):?>
                    <?php $product = $positions->getProduct()?>
                    <div class="nav-cart-item clearfix <?= $product->getIsInStock() ? '' : 'disabled'?>">
                        <div class="nav-cart-img">
                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                <?= Html::img($product->images[0]->getUrl('small'), ['alt'=>$product->title]);?>
                            </a>
                        </div>
                        <div class="nav-cart-title">
                            <a href="/catalog/<?= $product->category->slug ?>/<?= $product->id ?>">
                                <?= $product->title ?>
                            </a>
                            <div class="nav-cart-price">
                                <?php if($positions->size):?>
                                    <span>Размер: <?= $positions->size ?></span>
                                <?php endif;?>
                                <span><?= $positions->getQuantity() ?> x <?= (int)$product->getPrice() ?><i class="fa fa-ruble"></i></span>
                            </div>
                        </div>
                        <div class="nav-cart-remove">
                            <a data-id="<?= $positions->getId() ?>" id="header-remove_cart_item" class="remove"><i class="icon icon_close"></i></a>
                        </div>
                    </div>
                <?php endforeach;?>

            </div> <!-- end cart items -->

            <div class="nav-cart-summary">
                <span>Подитог</span>
                <span class="total-price"><span><?= $cart->getCost() ?></span><i class="fa fa-ruble"></i></span>
            </div>
            <?php if($activeItemsInCart > 0):?>
                <div class="nav-cart-actions mt-20">
                    <a href="/cart" class="btn btn-md btn-dark"><span>В корзину</span></a>
                    <a href="/cart/order" class="btn btn-md btn-color mt-10"><span>Оформить заказ</span></a>
                </div>
            <?php endif;?>
        </div>
    <?php endif;?>
</div>
<div class="menu-cart-amount right">
    <a <?php if($itemsInCart):?>href="/cart"<?php endif;?>>Корзина / <span><?= $cart->getCost() ?></span><i class="fa fa-ruble"></i></a>
</div>