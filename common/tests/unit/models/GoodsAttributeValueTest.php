<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\fixtures\AttributeDefinitionFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\GoodsAttributeBooleanValueFixture;
use common\fixtures\GoodsAttributeDictionaryDefinitionFixture;
use common\fixtures\GoodsAttributeDictionaryValueFixture;
use common\fixtures\GoodsAttributeFloatValueFixture;
use common\fixtures\GoodsAttributeIntegerValueFixture;
use common\fixtures\GoodsAttributeTextValueFixture;
use common\fixtures\GoodsFixture;
use common\models\Attribute;
use common\models\Goods;
use common\models\GoodsAttributeDictionaryDefinition;
use common\models\GoodsAttributeDictionaryValue;
use common\models\GoodsAttributeFloatValue;
use common\models\GoodsAttributeIntegerValue;
use common\models\GoodsAttributeTextValue;

class GoodsAttributeValueTest extends Unit
{

    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'attributeDefinition' => [
                'class' => AttributeDefinitionFixture::class,
//                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'category' => [
                'class' => CategoryFixture::class
            ],
            'attributeTextValue' => [
                'class' => GoodsAttributeTextValueFixture::class
            ],
            'attributeIntegerValue' => [
                'class' => GoodsAttributeIntegerValueFixture::class
            ],
            'attributeFloatValue' => [
                'class' => GoodsAttributeFloatValueFixture::class
            ],
            'attributeBooleanValue' => [
                'class' => GoodsAttributeBooleanValueFixture::class
            ],
            'attributeDictionaryValue' => [
                'class' => GoodsAttributeDictionaryValueFixture::class
            ],
            'attributeDictionaryDefinition' => [
                'class' => GoodsAttributeDictionaryDefinitionFixture::class
            ],
            'goods' => [
                'class' => GoodsFixture::class
            ]
        ];
    }

    public function _before()
    {
        parent::_before();
    }

    public function _after()
    {
        parent::_after();
    }

    public function testGetGoods()
    {
        $attrValue = GoodsAttributeTextValue::findOne(['goods_id' => 1, 'attribute_id' => 1]);
        $goods = $attrValue->goods;
        verify($goods)->equals(Goods::findOne(1));
    }

    public function testGetAttributeDefinition()
    {
        $attrValue = GoodsAttributeTextValue::findOne(['goods_id' => 1, 'attribute_id' => 1]);
        $goods = $attrValue->attributeDefinition;

        verify($goods)->equals(Attribute::findOne(1));
    }

    public function testGetDictionaryDefinition()
    {
        $attrValue = GoodsAttributeDictionaryValue::findOne(['goods_id' => 2, 'attribute_id' => 5]);
        $definition = $attrValue->dictionaryDefinition;

        verify($definition)->equals(GoodsAttributeDictionaryDefinition::findOne($attrValue->value));
    }

    public function testGetPresentableValueDictionary()
    {
        $attrValue = GoodsAttributeDictionaryValue::findOne(['goods_id' => 2, 'attribute_id' => 5]);
        $presValue = $attrValue->getPresentableValue();

        verify($presValue)->equals('first');
    }

    public function testInsertInexistingGoodsId()
    {
        $attrValue = new GoodsAttributeTextValue();
        $attrValue->attribute_id = 1;
        $attrValue->goods_id = 100;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertExistingGoodsAttributeCombination()
    {
        $attrValue = new GoodsAttributeTextValue();
        $attrValue->attribute_id = 1;
        $attrValue->goods_id = 1;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertInexistingAttributeId()
    {
        $attrValue = new GoodsAttributeTextValue();
        $attrValue->attribute_id = 100;
        $attrValue->goods_id = 1;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertIncorrectValueText()
    {
        $attrValue = new GoodsAttributeTextValue();
        $attrValue->attribute_id = 1;
        $attrValue->goods_id = 4;
        $attrValue->value = ['foo' => 'bar'];

        verify($attrValue->save())->false();
    }

    public function testInsertIncorrectValueInteger()
    {
        $attrValue = new GoodsAttributeIntegerValue();
        $attrValue->attribute_id = 2;
        $attrValue->goods_id = 4;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertIncorrectValueFloat()
    {
        $attrValue = new GoodsAttributeFloatValue();
        $attrValue->attribute_id = 3;
        $attrValue->goods_id = 4;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertIncorrectValueBoolean()
    {
        $attrValue = new GoodsAttributeIntegerValue();
        $attrValue->attribute_id = 4;
        $attrValue->goods_id = 4;
        $attrValue->value = '1foo';

        verify($attrValue->save())->false();
    }

    public function testInsertIncorrectValueDictionary()
    {
        $attrValue = new GoodsAttributeDictionaryValue();
        $attrValue->attribute_id = 5;
        $attrValue->goods_id = 4;
        $attrValue->value = 'foo';

        verify($attrValue->save())->false();
    }

    public function testInsertInexistingValueDictionary()
    {
        $attrValue = new GoodsAttributeDictionaryValue();
        $attrValue->attribute_id = 5;
        $attrValue->goods_id = 4;
        $attrValue->value = 100;

        verify($attrValue->save())->false();
    }

    public function testInsertCorrectText()
    {
        $attrValue = new GoodsAttributeTextValue();
        $attrValue->attribute_id = 1;
        $attrValue->goods_id = 4;
        $attrValue->value = 'foo';

        verify($attrValue->save())->true();
    }

    public function testInsertCorrectDictionary()
    {
        $attrValue = new GoodsAttributeDictionaryValue();
        $attrValue->attribute_id = 5;
        $attrValue->goods_id = 4;
        $attrValue->value = 2;

        verify($attrValue->save())->true();
    }
}