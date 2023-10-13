<?php

namespace App\Models;

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

    public function getValue(): int
    {
        return $this->value;
    }
}
