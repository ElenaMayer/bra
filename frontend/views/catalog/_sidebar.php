<?php

use yii\widgets\Menu;
use common\models\Product;
use common\models\StaticFunction;
?>

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
<div class="widget colors">
    <h3 class="widget-title uppercase">Цвет</h3>
    <?php  $colors = Product::getAllColorsArray($category->id)?>
    <ul class="list-no-dividers">
        <li <?php if(!Yii::$app->request->get('color') || Yii::$app->request->get('color') == 'all'):?>class="active"<?php endif;?>>
            <a href="<?= StaticFunction::addGetParamToCurrentUrl('color', 'all')?>" title="Все">Все</a>
        </li>
        <?php foreach ($colors as $key => $color):?>
            <li <?php if(Yii::$app->request->get('color') && Yii::$app->request->get('color') == $key):?>class="active"<?php endif;?>>
                <a href="<?= StaticFunction::addGetParamToCurrentUrl('color', $key)?>" title="<?= $color ?>">
                    <div class="color <?= $key?>"></div><div class="color-title"><?= $color?></div>
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

