<!-- Google Map -->
<div class="container mt-60">
    <div id="google-map" class="gmap" data-address="V Tytana St, Manila, Philippines"></div>

<!--    <div id="googleMap" data-icon="images/icon_location.png" data-lat="--><?//= Yii::$app->params['googleLat'] ?><!--" data-lon="--><?//= Yii::$app->params['googleLon'] ?><!--"></div>-->
</div>

<!-- Contact -->
<section class="section-wrap contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Адреса</h4>
                    <?php foreach (Yii::$app->params['address'] as $k => $v):?>
                        <h6><?=$k?></h6>
                        <address class="address"><?=$v?></address>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Контакты</h4>
                    <ul class="contact-info-list">
                        <li><span>Телефон: </span><a href="tel:<?=Yii::$app->params['phone']?>"><?=Yii::$app->params['phone']?></a></li>
                        <li><span>Email: </span><a href="mailto:<?=Yii::$app->params['email']?>" class="sliding-link"><?=Yii::$app->params['email']?></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-40 mt-mdm-40 contact-info">
                <div class="address-wrap">
                    <h4 class="uppercase">Часы работы</h4>
                    <p>Ежедневно: с 12:00 до 20:00</p>
                </div>
            </div>

        </div>
    </div>
</section> <!-- end contact -->
