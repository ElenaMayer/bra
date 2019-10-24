<?php

/* @var $this yii\web\View */
$this->title = 'Доставка';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section-wrap">
    <div class="container">
        <h1>Доставка</h1>
        <p>Наш магазин предоставляет несколько видов доставки товара:</p>
        <div class="pb-20"></div>
        <h3>Самовывоз</h3>
        <p>Для того, чтобы забронировать товар на сайте и затем забрать его в магазине, Вам необходимо:</p>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> выбрать товар и положить его в корзину;</li>
            <li><i class="icon arrow_carrot-right"></i> выбрать удобный способ оплаты (при оплате наличными товар бронируют на сутки);</li>
            <li><i class="icon arrow_carrot-right"></i> установить способ доставки - самовывоз;</li>
            <li><i class="icon arrow_carrot-right"></i> после оформления заказа с Вами свяжется менеджер для окончательного бронирования.</li>
        </ul>
        <p>Забрать товар можно по действующим <a href="/contact">адресам</a> с 12:00 до 20:00.</p>
        <div class="pb-20"></div>
        <img class="content_img" src="/img/shipping.jpg" alt="shipping" />
        <h3>Доставка товара по Новосибирску курьером</h3>
        <ul class="list arrows">
            <li>В связи с высокой загруженностью курьеров, временно изменены цены на доставку:</li>
            <li><i class="icon arrow_carrot-right"></i> Бесплатная доставка по городу Новосибирск от <?= Yii::$app->params['free_shipping_sum'] ?>₽.</li>

            <li>В остальных случаях:</li>
            <li><i class="icon arrow_carrot-right"></i> Доставка по городу - 200₽</li>
            <li><i class="icon arrow_carrot-right"></i> Отдаленные районы - 300₽</li>
            <li><i class="icon arrow_carrot-right"></i> Бердск - 450₽ (доставка по средам и пятницам)</li>
            <li><i class="icon arrow_carrot-right"></i> Кольцово - 350₽ (доставка по средам и субботам)</li>
            <li><i class="icon arrow_carrot-right"></i> Обь - 450₽ (доставка по средам и субботам)</li>
            <li><i class="fa fa-exclamation-circle"></i> Доставка с примеркой +50₽. С условиями примерки можно ознакомиться <a href="/tryon">здесь</a></li>
            <li><i class="icon icon_clock_alt"></i> Доставка производится на следующий день после формирования заявки, либо в любой удобный для Вас день с 14:00-19:00</li>
            <li><i class="icon arrow_carrot-right"></i>Оплата товара и курьерской доставки производится по предоплате на сайте онлайн, переводом на карту Сбербанк, Тинькоф, Альфабанк (в случае если примерка не нужна) или курьеру наличными (при примерке).</li>

            <li>Дла доставки укажите пожалуйста:</li>
            <li><i class="icon arrow_carrot-right"></i>Адрес;</li>
            <li><i class="icon arrow_carrot-right"></i>Номер телефона;</li>
            <li><i class="icon arrow_carrot-right"></i>Желаемое время доставки.</li>
        </ul>
        <div class="pb-20"></div>
        <h3>Отправка Почтой России (зависит от веса товара)</h3>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> если заказ до 1500₽ - доставка 200₽;</li>
            <li><i class="icon arrow_carrot-right"></i> если заказ от 1500₽ до 2500₽ - доставка 250₽;</li>
            <li><i class="icon arrow_carrot-right"></i> если заказ от 2500₽ до 4000₽ - доставка 350₽;</li>
            <li><i class="icon arrow_carrot-right"></i> если заказ от 4000₽ до 10000₽ - доставка 450₽.</li>
            <li><i class="icon icon_clock_alt"></i> СРОК доставки: обработка заказа и отправка 1 сутки, доставка от 4 до 10 дней (исключения - праздничные дни, из-за них возможны перебои в работе Почты России).</li>
        </ul>
        <div class="pb-20"></div>
        <h3>Отправка Транспортной Компанией (зависит от веса товара)</h3>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> если заказ до 1500₽ - доставка 350₽;</li>
            <li><i class="icon arrow_carrot-right"></i> если заказа от 1500₽ до 4000₽ - 450₽;</li>
            <li><i class="icon arrow_carrot-right"></i> если заказа от 4000₽ - 550₽.</li>
            <li><i class="icon icon_clock_alt"></i> СРОК доставки: обработка заказа и отправка 1 сутки, доставка от 2 до 5 дней (исключения - праздничные дни, из-за них возможны перебои в работе ТК).</li>
        </ul>
    </div>
</section>