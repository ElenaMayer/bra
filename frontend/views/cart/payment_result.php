<?php

/* @var $this yii\web\View */
if($order->payment == 'success') {
    $this->title = 'Оплата прошла успешно!';
} else {
    $this->title = 'Ошибка оплаты';
}

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="section-wrap">
    <div class="container payment">
        <?php if($order->payment == 'success'):?>
            <div class="row">
                <h1>Оплата заказа #<?=$order->id?> прошла успешно!</h1>
            </div>
            <div class="pb-10"></div>
            <div class="row">
                <img src="/img/success.png?1">
            </div>
            <div class="pb-20"></div>
            <div class="row">
                <h4>Благодарим за заказ, мы свяжемся с Вами в ближайшее время.</h4>
            </div>
        <?php else:?>
            <div class="row">
                <h1>Оплата заказа #<?=$order->id?> отклонена.</h1>
            </div>
            <div class="pb-10"></div>
            <div class="row">
                <img src="/img/fail.png?1">
            </div>
            <div class="pb-20"></div>
            <div class="row">
                <h4>К сожалению во время оплаты произошла ошибка.</h4>
                <?php if($order->email):?>
                    <h4>Повторно произвести оплату можно перейдя по ссылке в письме.</h4>
                <?php endif;?>
            </div>
        <?php endif;?>
    </div>
</section>