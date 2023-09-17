<?php

namespace common\fixtures;

use common\models\GoodsImage;

class GoodsImageFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsImage::class;
    public $depends = [
        GoodsFixture::class
    ];
}