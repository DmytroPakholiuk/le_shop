<?php

namespace common\tests\unit\models;

use common\fixtures\AttributeDefinitionFixture;
use common\fixtures\CategoryFixture;
use common\fixtures\GoodsAttributeBooleanValueFixture;
use common\fixtures\GoodsAttributeDictionaryDefinitionFixture;
use common\fixtures\GoodsAttributeDictionaryValueFixture;
use common\fixtures\GoodsAttributeFloatValueFixture;
use common\fixtures\GoodsAttributeIntegerValueFixture;
use common\fixtures\GoodsAttributeTextValueFixture;
use common\models\Attribute;
use common\models\Category;
use common\models\GoodsAttributeBooleanValue;
use common\models\GoodsAttributeDictionaryValue;
use common\models\GoodsAttributeFloatValue;
use common\models\GoodsAttributeIntegerValue;
use common\models\GoodsAttributeTextValue;
use PHPUnit\Framework\MockObject\MockBuilder;
use function PHPUnit\Framework\assertContainsOnlyInstancesOf;

class AttributeTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

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

    public function testGetValueForRootCategory()
    {
        //getting the root category
        $category = Category::findOne(1);
        $attributeDefinitions = Attribute::getAttributesForCategory($category);
        //root category only has its own attributes
        verify($attributeDefinitions)->arrayContainsEquals(Attribute::findOne(1))
            ->arrayNotContainsEquals(Attribute::findOne(4));
    }

    public function testGetValueForChildCategory()
    {
        //getting the child category
        $category = Category::findOne(2);
        $attributeDefinitions = Attribute::getAttributesForCategory($category);
        //the child category has its own attributes as well as parent's
        verify($attributeDefinitions)->arrayContainsEquals(Attribute::findOne(1))
            ->arrayContainsEquals(Attribute::findOne(4));
    }

    public function testGetValueForStaticText()
    {
        $model = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_TEXT]);
        $goodsIdRootCategory = 1;
        $goodsIdChildCategory = 2;

        //can get value for root category
        $valueForRoot = Attribute::getValueFor($model->id, $model->type, $goodsIdRootCategory);
        verify($valueForRoot)->equals(GoodsAttributeTextValue::findOne(1));

        //can get value of attribute for root category for child category
        $valueForChild = Attribute::getValueFor($model->id, $model->type, $goodsIdChildCategory);
        verify($valueForChild)->equals(GoodsAttributeTextValue::findOne(2));
    }

    public function testGetValueForStaticInteger()
    {
        $model = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_INTEGER]);
        $goodsIdRootCategory = 1;
        $goodsIdChildCategory = 2;

        //can get value for root category
        $valueForRoot = Attribute::getValueFor($model->id, $model->type, $goodsIdRootCategory);
        verify($valueForRoot)->equals(GoodsAttributeIntegerValue::findOne(1));

        //can get value of attribute for root category for child category
        $valueForChild = Attribute::getValueFor($model->id, $model->type, $goodsIdChildCategory);
        verify($valueForChild)->equals(GoodsAttributeIntegerValue::findOne(2));
    }

    public function testGetValueForStaticFloat()
    {
        $model = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_FLOAT]);
        $goodsIdRootCategory = 1;
        $goodsIdChildCategory = 2;

        //can get value for root category
        $valueForRoot = Attribute::getValueFor($model->id, $model->type, $goodsIdRootCategory);
        verify($valueForRoot)->equals(GoodsAttributeFloatValue::findOne(1));

        //can get value of attribute for root category for child category
        $valueForChild = Attribute::getValueFor($model->id, $model->type, $goodsIdChildCategory);
        verify($valueForChild)->equals(GoodsAttributeFloatValue::findOne(2));
    }

    public function testGetValueForStaticBoolean()
    {
        $model = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_BOOLEAN]);
        $goodsIdRootCategory = 1;
        $goodsIdChildCategory = 2;

        //can not get value of attribute for child category for root category
        $valueForRoot = Attribute::getValueFor($model->id, $model->type, $goodsIdRootCategory);
        verify($valueForRoot)->null();

        //can get value of attribute for child category
        $valueForChild = Attribute::getValueFor($model->id, $model->type, $goodsIdChildCategory);
        verify($valueForChild)->equals(GoodsAttributeBooleanValue::findOne(['goods_id' => 2, 'attribute_id' => 4]));
    }

    public function testGetValueStaticForDictionary()
    {
        $model = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_DICTIONARY]);
        $goodsIdRootCategory = 1;
        $goodsIdChildCategory = 2;

        //can not get value of attribute for child category for root category
        $valueForRoot = Attribute::getValueFor($model->id, $model->type, $goodsIdRootCategory);
        verify($valueForRoot)->null();

        //can get value of attribute for child category
        $valueForChild = Attribute::getValueFor($model->id, $model->type, $goodsIdChildCategory);
        verify($valueForChild)->equals(GoodsAttributeDictionaryValue::findOne(['goods_id' => 2, 'attribute_id' => 5]));
    }

    public function testGetValueText()
    {
        $attribute = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_TEXT]);
        $attributeValues = $attribute->attributeValues;
        assertContainsOnlyInstancesOf(GoodsAttributeTextValue::class, $attributeValues);
    }

    public function testGetValueInteger()
    {
        $attribute = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_INTEGER]);
        $attributeValues = $attribute->attributeValues;
        assertContainsOnlyInstancesOf(GoodsAttributeIntegerValue::class, $attributeValues);
    }

    public function testGetValueFloat()
    {
        $attribute = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_FLOAT]);
        $attributeValues = $attribute->attributeValues;
        assertContainsOnlyInstancesOf(GoodsAttributeFloatValue::class, $attributeValues);
    }

    public function testGetValueBoolean()
    {
        $attribute = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_BOOLEAN]);
        $attributeValues = $attribute->attributeValues;
        assertContainsOnlyInstancesOf(GoodsAttributeBooleanValue::class, $attributeValues);
    }

    public function testGetValueDictionary()
    {
        $attribute = Attribute::findOne(['type' => Attribute::ATTRIBUTE_TYPE_DICTIONARY]);
        $attributeValues = $attribute->attributeValues;
        assertContainsOnlyInstancesOf(GoodsAttributeDictionaryValue::class, $attributeValues);
    }

    public function testGetCategory()
    {
        $attribute = Attribute::findOne(1);
        $category = $attribute->category;
        verify($category)->equals(Category::findOne(1));
    }

    public function testInsertWithIncorrectName()
    {
        $attribute = new Attribute();
        $attribute->id = 100;
        $attribute->name = ['foo' => 'bar'];
        $attribute->category_id = 1;
        $attribute->type = Attribute::ATTRIBUTE_TYPE_TEXT;

        verify($attribute->save())->false();
    }

    public function testInsertWithIncorrectType()
    {
        $attribute = new Attribute();
        $attribute->id = 101;
        $attribute->name = 'foo';
        $attribute->category_id = 1;
        $attribute->type = 'sdfsdfsdf';

        verify($attribute->save())->false();
    }

    public function testInsertWithInexistingCategoryId()
    {
        $attribute = new Attribute();
        $attribute->id = 102;
        $attribute->name = 'foo';
        $attribute->category_id = 100;
        $attribute->type = Attribute::ATTRIBUTE_TYPE_TEXT;

        verify($attribute->save())->false();
    }

    public function testInsertCorrect()
    {
        $attribute = new Attribute();
        $attribute->id = 103;
        $attribute->name = 'foo';
        $attribute->category_id = 1;
        $attribute->type = Attribute::ATTRIBUTE_TYPE_TEXT;

        verify($attribute->save())->true();
    }
}