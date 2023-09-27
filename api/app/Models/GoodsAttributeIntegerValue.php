<?php

namespace App\Models;

/**
 * @property int $value
 */
class GoodsAttributeIntegerValue extends GoodsAttributeValue
{
    public $table = "attributes_integer";

    public function getValue(): int
    {
        return $this->value;
    }
}
