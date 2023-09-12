<?php

namespace common\fixtures;

use common\models\Attribute;
use yii\test\ActiveFixture;

class AttributeDefinitionFixture extends ActiveFixture
{
    public $modelClass = Attribute::class;
    public $depends = [
        CategoryFixture::class
    ];
}