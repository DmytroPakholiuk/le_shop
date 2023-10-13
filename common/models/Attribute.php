<?php

namespace common\models;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use yii\base\InvalidValueException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property string $name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $type
 * @property int $category_id
 * @property-read GoodsAttributeValue[] $attributeValues
 * @property-read Category $category
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'attributes';
    }

    public const ATTRIBUTE_TYPE_TEXT = 0;
    public const ATTRIBUTE_TYPE_INTEGER = 1;
    public const ATTRIBUTE_TYPE_FLOAT = 2;
    public const ATTRIBUTE_TYPE_BOOLEAN = 3;
    public const ATTRIBUTE_TYPE_DICTIONARY = 4;

    /**
     * returns array of strings describing possible attribute types
     *
     * @return string[]
     */
    public static function getPossibleTypes(): array
    {
        return [
            self::ATTRIBUTE_TYPE_TEXT => 'text',
            self::ATTRIBUTE_TYPE_INTEGER => 'integer',
            self::ATTRIBUTE_TYPE_FLOAT => 'float',
            self::ATTRIBUTE_TYPE_BOOLEAN => 'boolean',
            self::ATTRIBUTE_TYPE_DICTIONARY => 'dictionary'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'string'],
            [['name', 'type'], 'required'],
            [['type'], 'in', 'range' => array_keys(self::getPossibleTypes())],
            [['created_at','updated_at'], 'safe'],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']]
        ];
    }

    /**
     * Returns a new instance of GoodsAttributeValue according to the type of this attribute
     * @return GoodsAttributeValue
     */
    public function newGoodsAttributeValue(): GoodsAttributeValue
    {
        switch ($this->type){
            case self::ATTRIBUTE_TYPE_TEXT:
                return new GoodsAttributeTextValue();
            case self::ATTRIBUTE_TYPE_INTEGER:
                return new GoodsAttributeIntegerValue();
            case self::ATTRIBUTE_TYPE_FLOAT:
                return new GoodsAttributeFloatValue();
            case self::ATTRIBUTE_TYPE_BOOLEAN:
                return new GoodsAttributeBooleanValue();
            case self::ATTRIBUTE_TYPE_DICTIONARY:
                return new GoodsAttributeDictionaryValue();
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$this->type})");
        }
    }

    public static function getAttributesForCategory(Category|null $category, $asArray = false): array
    {
        $categoryIds = [];
        while ($category !== null){
            $categoryIds[] = $category->id;
            $category = $category->parent;
        }

        $attributes = Attribute::find()->where(['in', 'category_id', $categoryIds])
            ->orWhere(['is', 'category_id', new Expression('null')]);
        if ($asArray){
            $attributes->asArray();
        }
        return $attributes->all();
    }

    //TODO: move such initializing code away to some sort of factory.
    // See GoodsAttributeValueFactory in Laravel api part of the project
    public static function getValueFor(int $attributeId, string $type, int $goodsId): GoodsAttributeValue|null
    {
        $value = null;
        switch ($type){
            case self::ATTRIBUTE_TYPE_TEXT:
                $value = GoodsAttributeTextValue::find()->where(['attribute_id' => $attributeId])
                    ->andWhere(['goods_id' => $goodsId])->one();
                break;
            case self::ATTRIBUTE_TYPE_INTEGER:
                $value = GoodsAttributeIntegerValue::find()->where(['attribute_id' => $attributeId])
                    ->andWhere(['goods_id' => $goodsId])->one();
                break;
            case self::ATTRIBUTE_TYPE_FLOAT:
                $value = GoodsAttributeFloatValue::find()->where(['attribute_id' => $attributeId])
                    ->andWhere(['goods_id' => $goodsId])->one();
                break;
            case self::ATTRIBUTE_TYPE_BOOLEAN:
                $value = GoodsAttributeBooleanValue::find()->where(['attribute_id' => $attributeId])
                    ->andWhere(['goods_id' => $goodsId])->one();
                break;
            case self::ATTRIBUTE_TYPE_DICTIONARY:
                $value = GoodsAttributeDictionaryValue::find()
                    ->where(['attribute_id' => $attributeId])
                    ->andWhere(['goods_id' => $goodsId])->one();
                break;
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$type})");
        }
        /**
         * @var null|GoodsAttributeValue $value
         */
        return $value;
    }

    /**
     * Returns AttributeValue of appropriate type
     *
     * @return ActiveQuery
     */
    public function getAttributeValues(): ActiveQuery
    {
        switch ($this->type){
            case self::ATTRIBUTE_TYPE_TEXT:
                return $this->getTextValues();
            case self::ATTRIBUTE_TYPE_INTEGER:
                return $this->getIntegerValues();
            case self::ATTRIBUTE_TYPE_FLOAT:
                return $this->getFloatValues();
            case self::ATTRIBUTE_TYPE_BOOLEAN:
                return $this->getBooleanValues();
            case self::ATTRIBUTE_TYPE_DICTIONARY:
                return $this->getDictionaryValues();
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$this->type})");
        }
    }

    private function getTextValues()
    {
        return $this->hasMany(GoodsAttributeTextValue::class, ['attribute_id' => 'id']);
    }

    private function getIntegerValues()
    {
        return $this->hasMany(GoodsAttributeIntegerValue::class, ['attribute_id' => 'id']);
    }

    private function getFloatValues()
    {
        return $this->hasMany(GoodsAttributeFloatValue::class, ['attribute_id' => 'id']);
    }

    private function getBooleanValues()
    {
        return $this->hasMany(GoodsAttributeBooleanValue::class, ['attribute_id' => 'id']);
    }

    private function getDictionaryValues()
    {
        return $this->hasMany(GoodsAttributeDictionaryValue::class, ['attribute_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

}