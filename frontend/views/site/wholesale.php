<?php

/* @var $this yii\web\View */
$this->title = 'Опт';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section-wrap">
    <div class="container">
        <h1>Опт</h1>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> Нашей компанией открыты оптовые поставки носочных изделий.</li>
            <li><i class="icon arrow_carrot-right"></i> Лучшее цены и качество, напрямую от фабрики.</li>
            <li><i class="icon arrow_carrot-right"></i> Закупка оптовых линеек производится от <?= Yii::$app->params['wholesaleSum']?>₽ и отпускается упаковками (в одной упаковке 10 пар, 5 видов).</li>
            <li><i class="icon arrow_carrot-right"></i> Прайс с оптовыми ценами Вы можете запросить по номеру телефона <a href="tel:<?=Yii::$app->params['wholesalePhone']?>"><?=Yii::$app->params['wholesalePhone']?></a>.</li>
        </ul>
    </div>
</section>