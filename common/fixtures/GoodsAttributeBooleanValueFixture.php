<?php

namespace common\fixtures;

use common\models\GoodsAttributeBooleanValue;

class GoodsAttributeBooleanValueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeBooleanValue::class;
    public $depends = [
        AttributeDefinitionFixture::class,
        GoodsFixture::class
    ];
}