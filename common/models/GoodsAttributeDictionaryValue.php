<?php

namespace common\models;
/**
 * @property int $value
 * @property-read GoodsAttributeDictionaryDefinition $dictionaryDefinition
 */
class GoodsAttributeDictionaryValue extends GoodsAttributeValue
{
    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "dictionary";
    }

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
                ['value', 'required'],
                ['value', function($attribute, $params, $validator, $current){
                    $definition = GoodsAttributeDictionaryDefinition::findOne($current);
                    if ($this->attribute_id == $definition?->attribute_id){
                        return true;
                    }
                    $this->addError($attribute, 'The value id has to exist as dictionary
                     definition of this attribute.');
                    return false;
                }]
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