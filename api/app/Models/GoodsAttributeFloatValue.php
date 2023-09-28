<?php

namespace App\Models;

/**
 * @property double $value
 */
class GoodsAttributeFloatValue extends GoodsAttributeValue
{
    protected $table = "attributes_float";

    public function getValue(): float
    {
        return $this->value;
    }
}
