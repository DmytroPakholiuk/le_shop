<?php

namespace common\models;
/**
 * @property int $value_id
 * @property-read GoodsAttributeDictionaryDefinition $dictionaryDefinition
 */
class GoodsAttributeDictionaryValue extends GoodsAttributeValue
{
    public static function tableName(): ?string
    {
        return 'attributes_dictionary_values';
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['value', 'integer'],
                ['value', 'required']
            ]
        );
    }

    public function getValue()
    {
        return $this->dictionaryDefinition->value;
    }

    public function getDictionaryDefinition()
    {
        return $this->hasOne(GoodsAttributeDictionaryDefinition::class, ['id' => 'value_id']);
    }
}