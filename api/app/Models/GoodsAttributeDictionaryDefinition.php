<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property-read GoodsAttributeDefinition $attributeDefinition
 * @property-read GoodsAttributeDictionaryDefinition $attributeValueRecords
 */
class GoodsAttributeDictionaryDefinition extends Model
{
    use HasFactory;

    public $table = "attributes_dictionary_definitions";

    public function attributeDefinition(): BelongsTo
    {
        return $this->belongsTo(GoodsAttributeDefinition::class, "attribute_id", "id");
    }

    public function attributeValueRecords()
    {
        return $this->hasMany(GoodsAttributeDictionaryDefinition::class, "value", "id");
    }
}
