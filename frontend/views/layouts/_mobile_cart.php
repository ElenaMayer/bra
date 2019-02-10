<div class="nav-cart-outer">
    <div class="nav-cart-inner ">
        <?php $itemsInCart = Yii::$app->cart->getCount(); ?>
        <a href="/cart" class="nav-cart-icon"><?=$itemsInCart ? " $itemsInCart" : 0?></a>
    </div>
</div>