<?php

namespace common\fixtures;

use common\models\GoodsAttributeTextValue;

class GoodsAttributeTextValueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeTextValue::class;
    public $depends = [
        AttributeDefinitionFixture::class,
        GoodsFixture::class
    ];
}