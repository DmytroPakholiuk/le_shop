<?php

namespace App\Models;

/**
 * @property bool $value
 */
class GoodsAttributeBooleanValue extends GoodsAttributeValue
{
    protected $table = "attributes_boolean";

    public function getValue(): bool
    {
        return $this->value;
    }

    public function getPresentableValue(): string
    {
        return $this->getValue() ? "Yes" : "No";
    }
}
