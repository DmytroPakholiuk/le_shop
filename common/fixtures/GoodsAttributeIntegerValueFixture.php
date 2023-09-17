<?php

namespace common\fixtures;

use common\models\GoodsAttributeIntegerValue;

class GoodsAttributeIntegerValueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeIntegerValue::class;
    public $depends = [
        AttributeDefinitionFixture::class,
        GoodsFixture::class
    ];
}