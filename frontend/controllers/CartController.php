<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use frontend\models\Sberbank;
use Yii;
use yii\filters\AccessControl;

class CartController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['history', 'historyItem'],
                'rules' => [
                    ['allow' => true, 'actions' => ['history', 'historyItem'], 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionAdd($id, $size = null, $quantity = 1)
    {
        $product = Product::findOne($id);
        if ($product) {$position = $product->getCartPosition();
            if ($size)
                $position->size = $size;
            $cart = \Yii::$app->cart;
            $cart->put($position, $quantity);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'cart' => $this->renderPartial('@frontend/views/layouts/_cart'),
                'mobileCart' => $this->renderPartial('@frontend/views/layouts/_mobile_cart'),
            ];
        }
    }

    public function actionUpdate_cart_qty()
    {
        $get = Yii::$app->request->get();
        if($get && isset($get['id']) && isset($get['quantity']) && $get['quantity'] > 0) {

            $cart = \Yii::$app->cart;
            $position = $cart->getPositionById($get['id']);
            if ($position) {
                $product = $position->getProduct();
                if($product->getItemCount($position->size) > $get['quantity']){
                    $count = $get['quantity'];
                } else {
                    $count = $product->getItemCount($position->size);
                }
                $cart->update($position, $count);
            }

            $cart = \Yii::$app->cart;
            $product = $cart->getPositionById($get['id']);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'productTotal' => $product->getCost(),
                'cart' => $this->renderPartial('@frontend/views/layouts/_cart'),
                'mobileCart' => $this->renderPartial('@frontend/views/layouts/_mobile_cart'),
                'cartTotal' => $this->renderPartial('_total'),
            ];
        } else {
            return false;
        }

    }

    public function actionCart()
    {
        return $this->render('list');
    }

    public function actionRemove($id, $action)
    {
        \Yii::$app->cart->removeById($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if($action == 'main'){
            $cart = \Yii::$app->cart;
            return [
                'cartCount' => $cart->getCount(),
                'cartTotal' => $cart->getCost(),
                'cart' => $this->renderPartial('@frontend/views/layouts/_cart'),
                'mobileCart' => $this->renderPartial('@frontend/views/layouts/_mobile_cart'),
            ];
        } elseif($action == 'cart'){
            return [
                'cart' => $this->renderPartial('@frontend/views/layouts/_cart'),
                'mobileCart' => $this->renderPartial('@frontend/views/layouts/_mobile_cart'),
                'cartTotal' => $this->renderPartial('_total'),
            ];
        }

    }

    public function actionOrder()
    {
        /* @var $cart ShoppingCart */
        $cart = \Yii::$app->cart;
        $activeItemsInCart = $cart->getActiveCount();
        if($activeItemsInCart == 0)
            return $this->redirect('/cart');

        $get = Yii::$app->request->get();
        $ajax = false;
        if($get && isset($get['id'])) {
            $ajax = true;
            \Yii::$app->cart->removeById($get['id']);
        }

        $order = new Order();
        $order->payment_method = 'cash';

        $positions = $cart->getPositions();

        if($positions) {
            if ($order->load(\Yii::$app->request->post()) && $order->validate()) {
                $transaction = $order->getDb()->beginTransaction();
//                if (!Yii::$app->user->isGuest) {
//                    $order->user_id = Yii::$app->user->id;
//                    $order->id = date('ymdB');
//                }
                $order->id = date('ymdB');
                $order->save(false);

                foreach ($positions as $position) {
                    $product = $position->getProduct();
                    if ($product->getIsActive() && $product->getIsInStock()) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->title = $product->title;
                        $orderItem->price = $product->getPrice();
                        $orderItem->size = $position->size;
                        $orderItem->product_id = $product->id;
                        $qty = $position->getQuantity();
                        if($product->getItemCount($position->size) < $qty)
                            $qty = $product->getItemCount($position->size);
                        $orderItem->quantity = $qty;
                        if (!$orderItem->save(false)) {
                            $transaction->rollBack();
                            \Yii::$app->session->addFlash('error', 'Невозможно создать заказ. Пожалуйста свяжитесь с нами.');
                            return $this->redirect('/catalog');
                        } else {
                            $product->minusCount($orderItem->quantity, $position->size);
                        }
                    }
                }
                $transaction->commit();
                \Yii::$app->cart->removeAll();

//                if (!Yii::$app->user->isGuest) {
//                    $user = User::findOne(Yii::$app->user->id);
//                    if($order->fio) $user->fio = $order->fio;
//                    if($order->address) $user->address = $order->address;
//                    if($order->phone) $user->phone = $order->phone;
//                    $user->save(false);
//                }

                if($order->payment_method == 'card') {
                    $this->sberbankPay($order);
                } else {
                    \Yii::$app->session->addFlash('success', 'Спасибо за заказ. Мы свяжемся с Вами в ближайшее время.');
                    $order->sendEmail();

                    return $this->redirect('/');
                }
            }
//            if(!Yii::$app->user->isGuest) {
//                $order->fio = Yii::$app->user->getIdentity()->fio;
//                $order->address = Yii::$app->user->getIdentity()->address;
//                $order->phone = Yii::$app->user->getIdentity()->phone;
//                $order->email = Yii::$app->user->getIdentity()->email;
//            }
            if($ajax){
                return $this->renderPartial('order', [
                    'order' => $order,
                    'positions' => $positions,
                    'cart' => $cart,
                ]);
            } else {
                return $this->render('order', [
                    'order' => $order,
                    'positions' => $positions,
                    'cart' => $cart,
                ]);
            }
        } else {
            if($ajax){
                return false;
            } else
            $this->redirect('/cart/list');
        }
    }

    /**
     * Создание оплаты редеректим в шлюз сберабнка
     * @param $id
     * @return \yii\web\Response
     * @throws ErrorException
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     * @throws \Throwable
     */
    public function sberbankPay($order)
    {
        $sb = new Sberbank();
        $result = $sb->create($order);
        if (array_key_exists('errorCode', $result)) {
            throw new ErrorException($result['errorMessage']);
        }
        $formUrl = $result['formUrl'];

        $order->payment_url = $formUrl;
        $order->save();

        return $this->redirect($formUrl);
    }

    public function actionGet_courier_cost($type, $try = false){
        $cart = \Yii::$app->cart;
        $cartCost = $cart->getCost();
//        if($cartCost < Yii::$app->params['free_shipping_sum']) {
            $areaList = Order::getShippingArea();
//            $res = $areaList[$type]['price'];
            $res = Yii::$app->params['courier_shipping_price'];
            if($try == 'true'){
                return $res + 50;
            } else {
                return $res;
            }
//        } else {
//            return 0;
//        }
    }

    public function actionGet_rp_shipping_cost(){
        $cart = \Yii::$app->cart;
        $cartCost = $cart->getCost();
        if($cartCost < 1500) {
            return 200;
        } elseif($cartCost >= 1500 && $cartCost < 2500) {
            return 250;
        } elseif($cartCost >= 2500 && $cartCost < 4000) {
            return 350;
        } else {
            return 450;
        }
    }

    public function actionGet_tk_shipping_cost(){
        $cart = \Yii::$app->cart;
        $cartCost = $cart->getCost();
        if($cartCost < 1500) {
            return 350;
        } elseif($cartCost >= 1500 && $cartCost < 4000) {
            return 450;
        } else {
            return 550;
        }
    }

    /**
     * Сюда будет перенаправлен результат оплаты
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPayment_complete()
    {
        $orderId = Yii::$app->request->get('orderId');
        if (is_null($orderId)) {
            throw new NotFoundHttpException();
        }
        $sb = new Sberbank();
        $result = $sb->complete($orderId);
        $order = Order::findOne($result['OrderNumber']);
        if (is_null($order)) {
            throw new NotFoundHttpException();
        }
        //Проверяем статус оплаты если всё хорошо обновим инвойс и редерекним
        if (isset($result['OrderStatus']) && ($result['OrderStatus'] == 2)) {
            $action = 'success';
        } else {
            $action = 'fail';
        }
        $order->payment = $action;
        $order->save();
        $order->sendEmail();
        $this->redirect('/payment/'.$order->id);
    }

    public function actionPayment_result($orderId)
    {
        $order = Order::findOne($orderId);
        return $this->render('payment_result', [
            'order' => $order,
        ]);
    }

    public function actionCheck_promo($promo)
    {
        if($promo == Yii::$app->params['promo_shipping_free']){
            $cart = \Yii::$app->cart;
            $total = $cart->getCost();
            if($total >= 1000){
                $result = [
                    'type' => 'success',
                    'message' => 'Активирована бесплатная доставка курьером',
                ];
            } else {
                $result = [
                    'type' => 'error',
                    'message' => 'Необходимо добавить товаров на 1000 рублей',
                ];
            }
        } else {
            $result = [
                'type' => 'error',
                'message' => 'Промокод введен не верно',
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

//    public function actionHistory(){
//        $history = Order::find()->where(['user_id' => Yii::$app->user->id])->orderBy('id DESC')->all();
//        return $this->render('history', [
//            'history' => $history,
//        ]);
//    }
//
//    public function actionHistory_item($orderId){
//        $order = Order::findOne($orderId);
//        return $this->render('history_item', [
//            'order' => $order,
//        ]);
//    }
}

