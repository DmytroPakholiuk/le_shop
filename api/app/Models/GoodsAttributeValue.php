<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * An abstract class fit for manipulation of attribute values of any type
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property-read GoodsAttributeDefinition $attributeDefinition
 * @property-read Goods $goods
 * @property string $created_at
 * @property string $updated_at
 */
abstract class GoodsAttributeValue extends Model
{
    use HasFactory;

    /**
     * Allows to read the value from this record even if it is just known as an abstract GoodsAttributeValue object
     * @return mixed
     */
    public abstract function getValue(): mixed;

    /**
     * Returns a human-readable string that represents value of this attribute record
     * @return string
     */
    public function getPresentableValue(): string
    {
        return "{$this->getValue()}";
    }

    public function goods(): MorphMany
    {
        return $this->morphMany(Goods::class, "attributeValues");
    }

    public function attributeDefinition()
    {
        return $this->morphMany(GoodsAttributeDefinition::class, "attributeValues");
    }
}
