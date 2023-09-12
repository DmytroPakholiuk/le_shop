<?php

namespace common\fixtures;

use common\models\Goods;

class GoodsFixture extends \yii\test\ActiveFixture
{
    public $modelClass = Goods::class;
    public $depends = [
        CategoryFixture::class,
        UserFixture::class
    ];
}