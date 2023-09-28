<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $value
 * @property-read GoodsAttributeDictionaryDefinition $dictionaryDefinition
 */
class GoodsAttributeDictionaryValue extends GoodsAttributeValue
{
    protected $table = "attributes_dictionary_values";

    public function getValue(): int
    {
        return $this->value;
    }

    public function getPresentableValue(): string
    {
        return $this->dictionaryDefinition->value;
    }

    public function dictionaryDefinition(): HasOne
    {
        return $this->hasOne(GoodsAttributeDictionaryDefinition::class, "value", "id");
    }
}
