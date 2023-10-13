<?php

namespace App\Models;

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

    public static function getPresentableValueFor(mixed $value): string
    {
        return $value ? "Yes" : "No";
    }
}
