<?php

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;


class Sberbank
{
    /**
     * @var string Action сбербанка для регистрации оплаты
     */
    public $actionRegister = 'register.do';
    /**
     * @var string Action сбербанка для получения статуса оплаты
     */
    public $actionStatus = 'getOrderStatus.do';
    /* @var int Время жизни заказа в секундах */
    public $sessionTimeoutSecs = 1200;
    /**
     * @var string Url адрес страницы для возврата с платежного шлюза
     * необходимо указывать без host
     */
    public $returnUrl = '/payment/complete';

    public function create($model)
    {
        $post = [];
        $post['orderNumber'] = $model->id;
        $post['amount'] = $model->getCost() . 0 . 0;
        $post['returnUrl'] = Url::to($this->returnUrl, true);
        $post['sessionTimeoutSecs'] = $this->sessionTimeoutSecs;

        $result = $this->send($this->actionRegister, $post);
        return $result;
    }

    public function complete($orderId)
    {
        $post = [];
        $post['orderId'] = $orderId;
        return $this->send($this->actionStatus, $post);
    }
    /**
     * Откправка запроса в api сбербанка
     * @param $action string Action на который отпровляем запрос
     * @param $data array Параметры которые передаём в запрос
     * @return mixed Ответ сбербанка
     */
    private function send($action, $data)
    {
        $data['userName'] = Yii::$app->params['sberbankLogin'];
        $data['password'] = Yii::$app->params['sberbankPassword'];
        $url = Yii::$app->params['sberbankUrl'] . $action;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $out = curl_exec($curl);
        curl_close($curl);
        return Json::decode($out);
    }
}