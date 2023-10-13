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


    /**
     * @inheritDoc
     * @return string
     */
    public static function getTypeName(): string
    {
        return "dictionary";
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public static function getPresentableValueFor(mixed $value): string
    {
        return GoodsAttributeDictionaryDefinition::findOrFail($value)->value;
    }

    public function dictionaryDefinition(): HasOne
    {
        return $this->hasOne(GoodsAttributeDictionaryDefinition::class, "value", "id");
    }
}
