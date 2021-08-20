<?php

use frontend\assets\ContactAsset;

ContactAsset::register($this);

/* @var $this yii\web\View */
$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Google Map -->
<div class="container mt-60">
    <div id="googleMap" class="gmap"
         data-icon="/img/map_pin.png?1"
         data-lat-r="<?= Yii::$app->params['googleLatR'] ?>"
         data-lon-r="<?= Yii::$app->params['googleLonR'] ?>"
         data-lat-r2="<?= Yii::$app->params['googleLatR2'] ?>"
         data-lon-r2="<?= Yii::$app->params['googleLonR2'] ?>"
         data-lat-l="<?= Yii::$app->params['googleLatL'] ?>"
         data-lon-l="<?= Yii::$app->params['googleLonL'] ?>"
         data-lat-c="<?= Yii::$app->params['googleLatC'] ?>"
         data-lon-c="<?= Yii::$app->params['googleLonC'] ?>">

    </div>
</div>

<!-- Contact -->
<section class="section-wrap contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Адреса магазинов</h4>
                    <?php foreach (Yii::$app->params['address'] as $k => $v):?>
                        <h6><?=$k?></h6>
                        <address class="address"><?=$v?></address>
                    <?php endforeach;?>
                </div>
<!--                <div class="address-wrap">-->
<!--                    <h4 class="uppercase">Часы работы</h4>-->
<!--                    <p>Ежедневно: с 12:00 до 20:00</p>-->
<!--                </div>-->
            </div>
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Контакты</h4>
                    <ul class="contact-info-list">
                        <li><span><i class="fa fa-instagram"></i> Instagram: </span><a href="<?=Yii::$app->params['linkInstagram']?>"><?=Yii::$app->params['instagramName']?></a></li>
                        <li><span><i class="fa fa-whatsapp"></i> WhatsApp, звонки: </span><a href="tel:<?=Yii::$app->params['phone']?>"><?=Yii::$app->params['phone']?></a></li>
                        <li><span><i class="fa fa-envelope"></i> Почта: </span><a href="mailto:<?=Yii::$app->params['email']?>" class="sliding-link"><?=Yii::$app->params['email']?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Реквизиты</h4>
                    <ul class="contact-info-list">
                        <li><?=Yii::$app->params['ip']?></li>
                        <li><span>ИНН: </span><?=Yii::$app->params['inn']?></li>
                        <li><span>ОГРН: </span><?=Yii::$app->params['ogrn']?></li>
                        <li><span>Юридический адрес: </span><?=Yii::$app->params['ipAddress']?></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section> <!-- end contact -->
