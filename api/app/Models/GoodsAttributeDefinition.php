<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $type
 * @property int $category_id
 * @property-read GoodsAttributeValue[] $attributeValues
 * @property-read Category $category
 */
class GoodsAttributeDefinition extends Model
{
    use HasFactory;

    public const ATTRIBUTE_TYPE_TEXT = 0;
    public const ATTRIBUTE_TYPE_INTEGER = 1;
    public const ATTRIBUTE_TYPE_FLOAT = 2;
    public const ATTRIBUTE_TYPE_BOOLEAN = 3;
    public const ATTRIBUTE_TYPE_DICTIONARY = 4;

    protected $table = "attributes";
    public $timestamps = false;


    /**
     * returns array of strings describing possible attribute types
     *
     * @return string[]
     */
    public static function getPossibleTypes(): array
    {
        return [
            self::ATTRIBUTE_TYPE_TEXT => 'text',
            self::ATTRIBUTE_TYPE_INTEGER => 'integer',
            self::ATTRIBUTE_TYPE_FLOAT => 'float',
            self::ATTRIBUTE_TYPE_BOOLEAN => 'boolean',
            self::ATTRIBUTE_TYPE_DICTIONARY => 'dictionary'
        ];
    }


    /**
     * Returns a new instance of GoodsAttributeValue according to the type of this attribute
     * @return GoodsAttributeValue
     */
    public function newGoodsAttributeValue(): GoodsAttributeValue
    {
        switch ($this->type){
            case self::ATTRIBUTE_TYPE_TEXT:
                return new GoodsAttributeTextValue();
            case self::ATTRIBUTE_TYPE_INTEGER:
                return new GoodsAttributeIntegerValue();
            case self::ATTRIBUTE_TYPE_FLOAT:
                return new GoodsAttributeFloatValue();
            case self::ATTRIBUTE_TYPE_BOOLEAN:
                return new GoodsAttributeBooleanValue();
            case self::ATTRIBUTE_TYPE_DICTIONARY:
                return new GoodsAttributeDictionaryValue();
            default:
                throw new \Exception("This Attribute's type is unacceptable ({$this->type})");
        }
    }

    public function attributeValues(): MorphTo
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }
}
