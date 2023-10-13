<?php

namespace App\Models;

/**
 * @property string $value
 */
class GoodsAttributeTextValue extends GoodsAttributeValue
{
    protected $table = "attributes_text";

    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "text";
    }

    public function getValue(): string
    {
        return $this->value;
    }

}
