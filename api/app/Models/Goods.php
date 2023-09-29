<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property int $available
 * @property int $category_id
 * @property-read Category $category
 * @property int $author_id
 * @property-read User $author
 * @property int $target_credit_card
 * @property string $created_at
 * @property string $updated_at
 * @property-read GoodsImage[] $images
 * @property-read GoodsAttributeValue[] $attributeValues
 * @property-read GoodsAttributeDefinition[] $attributeNames
 */
class Goods extends Model
{
    use HasFactory;

    protected $table = "goods";

    protected $fillable = [
        "id",
        "name",
        "description",
        "price",
        "available",
        "category_id",
        "author_id",
        "created_at",
        "updated_at",
        "author_id" // todo: same security concerns as with categories: find a way to show all safely
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, "author_id", "id");
    }

    public function attributeValues(): MorphTo
    {
        return $this->morphTo();
    }

    public function attributeNames()
    {
        return $this->category->hasMany(GoodsAttributeDefinition::class, "category_id", "id");
    }
}
