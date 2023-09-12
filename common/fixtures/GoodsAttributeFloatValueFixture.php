<?php

namespace common\fixtures;

use common\models\GoodsAttributeFloatValue;

class GoodsAttributeFloatValueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeFloatValue::class;
    public $depends = [
        AttributeDefinitionFixture::class,
        GoodsFixture::class
    ];
}