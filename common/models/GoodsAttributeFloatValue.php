<?php

namespace common\models;
/**
 * @property float $value
 */
class GoodsAttributeFloatValue extends GoodsAttributeValue
{
    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "float";
    }

    public static function tableName(): ?string
    {
        return 'attributes_float';
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['value', 'double'],
                ['value', 'required']
            ]
        );
    }

    public function getValue()
    {
        return $this->value;
    }
}