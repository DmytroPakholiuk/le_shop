<?php

namespace App\Models;

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

    public function getValue(): float
    {
        return $this->value;
    }
}
