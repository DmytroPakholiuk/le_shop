<?php

namespace frontend\controllers;

use common\models\Goods;

class GoodsController extends \yii\rest\ActiveController
{
    public $modelClass = Goods::class;

}