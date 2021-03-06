<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\Order;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model) {
            return ['class' => $model->status];
        },
        'columns' => [
            'id',
            'fio',
            'phone',
            [
                'attribute'=>'status',
                'value' => function ($model) {
                    return $model->getStatuses()[$model->status];
                },
                'filter' => Order::getStatuses()
            ],
            [
                'attribute'=>'shipping_method',
                'value' => function ($model) {
                    return Order::getShippingMethods()[$model->shipping_method];
                },
            ],
            [
                'header'=>'Сумма',
                'value' => function ($model) {
                    return $model->getCost();
                }
            ],
            [
                'attribute'=>'payment',
                'value' => function ($model) {
                    return $model->payment == 'success' ? 'Есть' : 'Нет';
                },
                'filter' => ['success' => 'Есть']
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn'
            ],
        ],
    ]); ?>

</div>
