<?php

namespace common\models;
/**
 * @property int $value
 */
class GoodsAttributeIntegerValue extends GoodsAttributeValue
{
    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "integer";
    }

    public static function tableName(): ?string
    {
        return 'attributes_integer';
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
        return $this->value;
    }
}