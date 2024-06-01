<?php

namespace backend\controllers;

use backend\models\OrderSearch;
use common\models\Goods;
use common\models\Order;
use common\models\OrderGoods;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class OrderController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $order = new Order();
        $orderGoods = new OrderGoods();
        if (\Yii::$app->request->isPost && $order->load(\Yii::$app->request->post()) && $order->validate()){
            $orderGoods->load(\Yii::$app->request->post());
            $goods = Goods::findOne($orderGoods->goods_id);
            $order->sum_price = $goods->price;
            $order->customer_id = \Yii::$app->user->id;
            $order->save();

            $orderGoods->load(\Yii::$app->request->post());
            $orderGoods->order_id = $order->id;
            $orderGoods->save();

            return $this->redirect(Url::to(['view', 'id' => $order->id]));
        } else {
//            $categories = Order::find()->select('name')->where(['status' => 1])->indexBy('id')->column();

            return $this->render('create', ['order' => $order, 'orderGoods' => $orderGoods]);
        }
    }
    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Order::findOne($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionDelete($id)
    {
        if(!$model = Order::findOne($id)){
            throw new NotFoundHttpException();
        };

        $model->delete();

        return $this->redirect('/order/index');
    }
}