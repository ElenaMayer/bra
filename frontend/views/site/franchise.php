<?php

/* @var $this yii\web\View */
$this->title = 'Франшиза';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section-wrap">
    <div class="container">
        <img class="content_img" src="/img/fr_photo.jpg" alt="franchise" />
        <h1>Франшиза</h1>
        <p>Франшиза магазинов белья LACORSA открыта в регионах.</p>
        <p>Подробную информацию и презентацию и чек-лист открытия для франчайзи Вы можете
            получить по ссылке <a href="<?=Yii::$app->params['franchise_url']?>">
                <?=Yii::$app->params['franchise_url']?></a></p>

    </div>
</section>