<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Validator;

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

    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        $definition = GoodsAttributeDictionaryDefinition::find($value);
        if ($value == null) {
            $validator->errors()->add("value", "The value does not exist among dictionary definitions");
            return false;
        }
        if ($definition->attribute_id != $attributeDefinition->id) {
            $validator->errors()->add("value", "The value corresponds to the wrong attribute definition");
            return false;
        }

        return true;
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
