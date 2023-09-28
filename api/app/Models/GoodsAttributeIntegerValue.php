<?php

namespace App\Models;

/**
 * @property int $value
 */
class GoodsAttributeIntegerValue extends GoodsAttributeValue
{
    protected $table = "attributes_integer";

    public function getValue(): int
    {
        return $this->value;
    }
}
