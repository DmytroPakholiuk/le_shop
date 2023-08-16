<?php

namespace common\models;
/**
 * @property int $value
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

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPresentableValue(): string
    {
        return $this->dictionaryDefinition->value;
    }

    public function getDictionaryDefinition()
    {
        return $this->hasOne(GoodsAttributeDictionaryDefinition::class, ['id' => 'value']);
    }
}