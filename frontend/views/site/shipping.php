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
        <h3>Доставка товара по Новосибирску курьером</h3>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> если заказ до 1000₽ - доставка 150₽ (в неотдаленные районы города);</li>
            <li><i class="icon arrow_carrot-right"></i> если заказ от 1000₽ - <b>ДОСТАВКА БЕСПЛАТНО</b> в неотделанные районы города (доставка бесплатная при покупке товара, если Вы ничего не приобретаете, то оплата курьера - 150₽);</li>
            <li><i class="icon arrow_carrot-right"></i> в отдалённые районы от 200₽;</li>
            <li><i class="icon arrow_carrot-right"></i> Бердск, Искитим, Обь от 350₽.</li>
            <li><i class="icon icon_clock_alt"></i> СРОК доставки: 1-2 суток, в зависимости от загруженности курьера (временной промежуток доставки обсуждается с менеджером после оформления заказа).
            <li><i class="fa fa-exclamation-circle"></i> При заказе курьером возможна примерка. С условиями примерки можно ознакомиться <a href="/tryon">здесь</a></li>
            </li>
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