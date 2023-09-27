<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property int $parent_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read Category $parent
 * @property-read Category[] $children
 */
class Category extends Model
{
    use HasFactory;

    public $table = "categories";

    public function goods(): HasMany
    {
        return $this->hasMany(Goods::class, "category_id", "id");
    }

    public function attributeDefinitions(): HasMany
    {
        return $this->hasMany(GoodsAttributeDefinition::class, "category_id", 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, "parent_id", "id");
    }
}
