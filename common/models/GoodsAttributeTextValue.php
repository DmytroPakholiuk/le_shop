<?php

namespace common\models;
/**
 * @property string $value
 */
class GoodsAttributeTextValue extends GoodsAttributeValue
{
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