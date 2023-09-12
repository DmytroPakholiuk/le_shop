<?php

namespace common\fixtures;

use common\models\GoodsAttributeDictionaryValue;

class GoodsAttributeDictionaryValueFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeDictionaryValue::class;
    public $depends = [
        AttributeDefinitionFixture::class,
        GoodsAttributeDictionaryDefinitionFixture::class,
        GoodsFixture::class
    ];
}