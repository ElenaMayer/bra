<?php

use yii\widgets\Menu;
use common\models\Product;
use common\models\StaticFunction;
?>

<!-- Sidebar -->
<aside class="col-md-3 sidebar left-sidebar">

    <!-- Categories -->
    <div class="widget categories">
        <h3 class="widget-title uppercase">Категории</h3>
        <?= Menu::widget([
            'items' => $menuItems,
            'options' => [
                'class' => 'list-no-dividers',
            ],
        ]); ?>
    </div>

    <!-- Select size -->
    <div class="widget tags clearfix">
        <h3 class="widget-title uppercase">Размер</h3>
        <?php $sizes = Product::getAllSizesArray($category->id)?>
        <a href="<?= StaticFunction::addGetParamToCurrentUrl('size', 'all')?>" title="Все" class="<?php if(!Yii::$app->request->get('size') || Yii::$app->request->get('size') == 'all') echo 'active'?>">Все</a>
        <?php foreach ($sizes as $size):?>
            <a href="<?= StaticFunction::addGetParamToCurrentUrl('size', $size)?>" title="<?= $size ?>" class=" <?php if(Yii::$app->request->get('size') && Yii::$app->request->get('size') == $size) echo 'active'?>">
                <?= $size ?>
            </a>
        <?php endforeach;?>
    </div>

    <!-- Select color -->
    <div class="widget categories">
        <h3 class="widget-title uppercase">Цвет</h3>
        <?php  $colors = Product::getAllColorsArray($category->id)?>
        <ul class="list-no-dividers">
            <li class="<?php if(!Yii::$app->request->get('color') || Yii::$app->request->get('color') == 'all') echo 'active'?>">
                <a href="<?= StaticFunction::addGetParamToCurrentUrl('color', 'all')?>" title="Все">Все</a>
            </li>
        <?php foreach ($colors as $color):?>
                <li class=" <?php if(Yii::$app->request->get('color') && Yii::$app->request->get('color') == $color) echo 'active'?>">
                    <a href="<?= StaticFunction::addGetParamToCurrentUrl('color', $color)?>" title="<?= $color ?>">
                        <?= $color?>
                    </a>
                </li>
        <?php endforeach;?>
        </ul>
    </div>

<!--     Фильтр по цене-->
<!--    <div class="widget filter-by-price clearfix">-->
<!--        <h3 class="widget-title uppercase">Цена</h3>-->
<!---->
<!--        <div id="slider-range"></div>-->
<!--        <p>-->
<!--            <label for="amount">Цена:</label>-->
<!--            <input type="text" id="amount" readonly style="border:0;">-->
<!--            <a href="#" class="btn btn-sm btn-dark">Искать</a>-->
<!--        </p>-->
<!--    </div>-->

    <!-- Bestsellers -->
    <div class="widget bestsellers">
        <div class="products-widget">
            <h3 class="widget-title uppercase">Новинки</h3>
            <ul class="product-list-widget">
                <?php $products = Product::getNovelties(2);?>
                <?php foreach ($products as $product):?>
                    <li class="clearfix">
                        <a href="/catalog/<?= $product->category->slug?>/<?= $product->id?>">
                            <?php $images = $product->images; ?>
                            <img src="<?=$images[0]->getUrl('small')?>" alt="<?= $product->title?>">
                            <span class="product-title"><?=$product->title?></span>
                        </a>
                        <span class="price">
                          <ins>
                            <span class="ammount"><?=$product->new_price ? $product->new_price : (int)$product->price?><i class="fa fa-ruble"></i></span>
                          </ins>
                        </span>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>

</aside> <!-- end sidebar -->