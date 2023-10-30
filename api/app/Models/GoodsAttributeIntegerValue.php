<?php

namespace App\Models;

use Illuminate\Validation\Validator;

/**
 * @property int $value
 */
class GoodsAttributeIntegerValue extends GoodsAttributeValue
{
    protected $table = "attributes_integer";

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "integer";
    }

    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        return $validator->validateInteger("value", $value);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
