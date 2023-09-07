<?php

namespace frontend\controllers;

use common\models\Goods;
use yii\filters\auth\HttpBasicAuth;

class GoodsController extends \yii\rest\ActiveController
{
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = [
////            'class' => ::class,
//        ];
//        return $behaviors;
//    }

    public $modelClass = Goods::class;

}