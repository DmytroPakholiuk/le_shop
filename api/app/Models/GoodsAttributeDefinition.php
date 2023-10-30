<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property string $name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $type
 * @property int $category_id
 * @property-read GoodsAttributeValue[] $attributeValues
 * @property-read Category $category
 * @property-read string $typeName
 */
class GoodsAttributeDefinition extends Model
{
//    use HasFactory;

    protected $table = "attributes";
    public $timestamps = false;

    public static function getAttributesForCategory(Category|null $category): Collection
    {
        $categoryIds = [];
        while ($category !== null){
            $categoryIds[] = $category->id;
            $category = $category->parent;
        }

        $attributes = GoodsAttributeDefinition::whereIn('category_id', $categoryIds)
            ->orWhereNull('category_id');

        return $attributes->get();
    }

//    public function attributeValues(): MorphTo
//    {
//        return $this->morphTo();
//    }

    public function getTypeNameAttribute()
    {
        return GoodsAttributeValueFactory::getPossibleTypeNames()[$this->type];
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }


    /**
     * Returns AttributeValue of appropriate type
     *
     * @return HasMany
     * @throws \Exception
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(GoodsAttributeValueFactory::getClassByType($this->type), 'attribute_id', 'id');
    }
}
