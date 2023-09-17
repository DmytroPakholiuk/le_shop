<?php

namespace common\fixtures;

use common\models\GoodsAttributeDictionaryDefinition;

class GoodsAttributeDictionaryDefinitionFixture extends \yii\test\ActiveFixture
{
    public $modelClass = GoodsAttributeDictionaryDefinition::class;
    public $depends = [
        AttributeDefinitionFixture::class,
    ];
}