<?php

/* @var $this yii\web\View */
$this->title = 'Примерка';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section-wrap">
    <div class="container">
        <h1>Примерка</h1>
        <p>Наш товар можно заказать к примерке. Будем рады помочь с выбором и предоставить выбор.</p>
        <p>Условия примерки:</p>
        <ul class="list arrows">
            <li><i class="icon arrow_carrot-right"></i> доставка с примеркой от 1000₽ бесплатная (не в отдаленные районы).
                Если покупка до 1000₽, то оплачивается работа курьера от 150₽, в зависимости от района и отдаленности;</li>
            <li><i class="icon arrow_carrot-right"></i> к примерке можно выбрать до 15 видов товаров и аксессуаров;</li>
            <li><i class="icon arrow_carrot-right"></i> положить в корзину выбранный товар;</li>
            <li><i class="icon arrow_carrot-right"></i> выбрать способ доставки - курьер (с примеркой);</li>
            <li><i class="icon arrow_carrot-right"></i> выбрать удобный способ оплаты (перевод на карту или наличные);</li>
            <li><i class="icon arrow_carrot-right"></i> указать в комментарии к заказу что вам необходима примерка;</li>
            <li><i class="icon arrow_carrot-right"></i> после заказа с вами свяжется менеджер и обговорит условия доставки.</li>
            <p>Если у вас остались вопросы, всегда звоните по телефону <a href="tel:<?=Yii::$app->params['phone']?>"><?=Yii::$app->params['phone'];?></a>.</p>
        </ul>
    </div>
</section>