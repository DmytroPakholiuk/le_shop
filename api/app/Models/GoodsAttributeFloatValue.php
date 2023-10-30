<?php

namespace App\Models;

use Illuminate\Validation\Validator;

/**
 * @property double $value
 */
class GoodsAttributeFloatValue extends GoodsAttributeValue
{
    protected $table = "attributes_float";

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "float";
    }

    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        if (! is_numeric($value)) {
            $validator->errors()->add("value", "Value of this attribute must be of type float");
            return false;
        }

        return true;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
