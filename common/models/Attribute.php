<?php

namespace common\models;
use yii\base\InvalidValueException;
use yii\db\ActiveQuery;

/**
 * @property string $name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $type
 * @property int $category_id
 * @property-read GoodsAttributeValue[] $attributeValues
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

    /**
     * returns array of strings describing possible attribute types
     *
     * @return string[]
     */
    public static function getPossibleTypes(): array
    {
        return [
            'text',
            'integer',
            'float',
            'boolean',
            'dictionary'
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'type'], 'string'],
            [['name', 'type'], 'required'],
            ['type', function($value){
                return in_array(strtolower($value), self::getPossibleTypes());
            }],
            [['created_at','updated_at'], 'safe'],
        ];
    }

    /**
     * Returns AttributeValue of appropriate type
     *
     * @return ActiveQuery
     */
    public function getAttributeValues(): ActiveQuery
    {
        switch ($this->type){
            case 'text':
                return $this->getTextValues();
            case 'integer':
                return $this->getIntegerValues();
            case 'float':
                return $this->getFloatValues();
            case 'boolean':
                return $this->getBooleanValues();
            case 'dictionary':
                return $this->getDictionaryValues();
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$this->type})");
        }
    }

    private function getTextValues()
    {
        return $this->hasMany(GoodsAttributeTextValue::class, ['attribute_id' => 'id']);
    }

}