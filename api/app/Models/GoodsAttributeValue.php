<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Validation\Validator;

/**
 * An abstract class fit for manipulation of attribute values of any type
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
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
     * This function is used to validate the value. Conventional validation rules might be insufficient
     * to implement separate validation logic for different types. So overwrite this method to perform additional value
     * validation
     * @param Validator $validator
     * @return bool
     */
    public static function validateValue(Validator $validator, mixed $value, GoodsAttributeDefinition $attributeDefinition = null): bool
    {
        return true;
    }

    protected $fillable = [
        "goods_id",
        "attribute_id",
        "value"
    ];
    public $timestamps = false;

    /**
     * Allows to read the value from this record even if it is just known as an abstract GoodsAttributeValue object
     * @return mixed
     */
    public abstract function getValue(): mixed;


    /**
     * It should return the name of the attribute type this class is of.
     * @return string
     */
    public abstract static function getTypeName(): string;

    /**
     * Returns a human-readable string that represents value of this attribute record
     * @return string
     */
    public function getPresentableValue(): string
    {
        return self::getPresentableValueFor($this->getValue());
    }

    public static function getPresentableValueFor(mixed $value): string
    {
        return "{$value}";
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
