<?php

namespace common\models;
/**
 * @property boolean $value
 */
class GoodsAttributeBooleanValue extends GoodsAttributeValue
{
    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "boolean";
    }

    public static function tableName(): ?string
    {
        return 'attributes_boolean';
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['value', 'boolean'],
                ['value', 'required']
            ]
        );
    }
    public function getValue()
    {
        return $this->value;
    }

    public function getPresentableValue(): string
    {
        return $this->getValue() ? 'Yes' : 'No';
    }
}