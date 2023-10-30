<?php

namespace App\Models;

use Illuminate\Validation\Validator;

/**
 * @property string $value
 */
class GoodsAttributeTextValue extends GoodsAttributeValue
{
    protected $table = "attributes_text";

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "text";
    }

    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        return $validator->validateString("value", $value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

}
