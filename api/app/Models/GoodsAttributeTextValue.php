<?php

namespace App\Models;

/**
 * @property string $value
 */
class GoodsAttributeTextValue extends GoodsAttributeValue
{
    protected $table = "attributes_text";

    public function getValue(): string
    {
        return $this->value;
    }

}
