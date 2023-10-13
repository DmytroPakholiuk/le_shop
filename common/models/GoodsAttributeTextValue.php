<?php

namespace common\models;
/**
 * @property string $value
 */
class GoodsAttributeTextValue extends GoodsAttributeValue
{
    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "text";
    }

    public static function tableName(): ?string
    {
        return 'attributes_text';
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                ['value', 'string'],
                ['value', 'required']
            ]
        );
    }

    public function getValue()
    {
        return $this->value;
    }
}