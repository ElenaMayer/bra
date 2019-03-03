<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use common\models\User;
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

    public function actionAdd($id, $size, $quantity = 1)
    {
        $product = Product::findOne($id);
        if ($product) {$position = $product->getCartPosition();
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

//            $product = Product::findOne($get['id']);
//            if($product->count > $get['quantity']){
//                $count = $get['quantity'];
//            } else {
//                $count = $product->count;
//            }
            $this->updateQty($get['id'], $get['quantity']);
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

    public function updateQty($id, $quantity)
    {
        $cart = \Yii::$app->cart;
        $position = $cart->getPositionById($id);
        if ($position) {
            $cart->update($position, $quantity);
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
//                        if($product->count < $qty)
//                            $qty = $product->count;
                        $orderItem->quantity = $qty;
                        if (!$orderItem->save(false)) {
                            $transaction->rollBack();
                            \Yii::$app->session->addFlash('error', 'Невозможно создать заказ. Пожалуйста свяжитесь с нами.');
                            return $this->redirect('/catalog');
                        } else {
//                            $product->minusCount($orderItem->quantity);
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

                \Yii::$app->session->addFlash('success', 'Спасибо за заказ. Мы свяжемся с Вами в ближайшее время.');
                $order->sendEmail();

                return $this->redirect('/');
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

    public function actionGet_courier_cost(){
        $cart = \Yii::$app->cart;
        $cartCost = $cart->getCost();
        if($cartCost < 1000) {
            return 150;
        } else {
            return 0;
        }
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

