<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property-read GoodsAttributeDefinition $attributeDefinition
 * @property-read GoodsAttributeDictionaryDefinition $attributeValueRecords
 */
class GoodsAttributeDictionaryDefinition extends Model
{
    use HasFactory;

    protected $table = "attributes_dictionary_definitions";
    public $timestamps = false;

    protected $fillable = [
        "attribute_id",
        "value"
    ];

    public function attributeDefinition(): BelongsTo
    {
        return $this->belongsTo(GoodsAttributeDefinition::class, "attribute_id", "id");
    }

    public function attributeValueRecords()
    {
        return $this->hasMany(GoodsAttributeDictionaryDefinition::class, "value", "id");
    }
}
