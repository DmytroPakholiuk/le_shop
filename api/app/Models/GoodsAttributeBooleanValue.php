<?php

namespace App\Models;


use Illuminate\Validation\Validator;

/**
 * @property bool $value
 */
class GoodsAttributeBooleanValue extends GoodsAttributeValue
{
    protected $table = "attributes_boolean";


    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "boolean";
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        return $validator->validateBoolean("value", $value);
    }

    public static function getPresentableValueFor(mixed $value): string
    {
        return $value ? "Yes" : "No";
    }
}
