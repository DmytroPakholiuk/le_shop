<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use stdClass;

//todo: maybe implement some sort of caching for reflection instances to avoid creation
// of empty Eloquent models on each call (?)
/**
 * This factory is made to ease the manipulations with different types of attributes and their values.
 * To add another type under its support you will have to:
 *  - create Eloquent class that extends GoodsAttributeValue
 *  - in this class define the static function getTypeName() and specify $table
 *  - add another class constant to this class like ATTRIBUTE_TYPE_TEXT = 0
 *  - add your $type => $className item to getPossibleTypes() method
 */
class GoodsAttributeValueFactory
{
    public const ATTRIBUTE_TYPE_TEXT = 0;
    public const ATTRIBUTE_TYPE_INTEGER = 1;
    public const ATTRIBUTE_TYPE_FLOAT = 2;
    public const ATTRIBUTE_TYPE_BOOLEAN = 3;
    public const ATTRIBUTE_TYPE_DICTIONARY = 4;

    /**
     * returns array of classnames that represent valid types of attributes
     *
     * @return string[]
     */
    public static function getPossibleTypes(): array
    {
        return [
            self::ATTRIBUTE_TYPE_TEXT => GoodsAttributeTextValue::class,
            self::ATTRIBUTE_TYPE_INTEGER => GoodsAttributeIntegerValue::class,
            self::ATTRIBUTE_TYPE_FLOAT => GoodsAttributeFloatValue::class,
            self::ATTRIBUTE_TYPE_BOOLEAN => GoodsAttributeBooleanValue::class,
            self::ATTRIBUTE_TYPE_DICTIONARY => GoodsAttributeDictionaryValue::class
        ];
    }

    /**
     * Returns a classname of that type.
     * @param int $type
     * @return string
     * @throws \Exception
     */
    public static function getClassByType(int $type): string
    {
        try {
            return self::getPossibleTypes()[$type];
        } catch (\Throwable $throwable) {
            throw new \Exception("This Attribute's type is unacceptable ({$type})");
        }
    }

    /**
     * Returns an array containing the namesof the types like [ATTRIBUTE_TYPE_DICTIONARY => "dictionary"]
     * @return array
     */
    public static function getPossibleTypeNames(): array
    {
        $typeNames = [];
        foreach (self::getPossibleTypes() as $type => $class){
            $typeNames[$type] = call_user_func($class .'::getTypeName');
        }

        return $typeNames;
    }

    /**
     * Returns table name for the requested type of attribute. Uses reflection to do so.
     * @param int $type
     * @return string
     * @throws \Exception
     */
    public static function getTableByType(int $type): string
    {
        return self::newGoodsAttributeValue($type)->getTable();
    }

    /**
     * Returns a new instance of GoodsAttributeValue according to the type of this attribute. Uses reflection to do so.
     * @return GoodsAttributeValue
     * @throws \Exception
     */
    public static function newGoodsAttributeValue(int $type): GoodsAttributeValue
    {
        $reflect = new \ReflectionClass(self::getClassByType($type));
        return $reflect->newInstanceArgs();
    }

    /**
     * @throws \Exception
     */
    public static function getValueJoinFor(int $attributeId, int $type, int $goodsId): stdClass|null
    {
        $value = null;
        $class = self::getClassByType($type);
        $valueTable = self::getTableByType($type);
        $value = DB::table('attributes')
            ->select([
                "attributes.id",
                "name",
                "{$valueTable}.value",
                "type",
                "category_id",
                "goods_id"
            ])->where(["attributes.id" => $attributeId])
            ->leftJoin($valueTable,
                function (JoinClause $join) use ($valueTable, $goodsId) {
                    $join->on("attributes.id", "=", "{$valueTable}.attribute_id")
                    ->where(["goods_id" => $goodsId]);
            })->first();

        if (! is_null($value?->value)){
            /**
             * @var stdClass $value
             */
            $value->presentableValue = call_user_func($class . "::getPresentableValueFor", $value->value);
        } else {
            $value->goods_id = $goodsId;
            $value->presentableValue = null;
        }

        return $value;
    }

    public static function getValueFor(int $attributeId, int $type, int $goodsId): GoodsAttributeValue|null
    {
        $class = self::getClassByType($type);
        /**
         * @var Builder $query
         * @var GoodsAttributeValue|null $value
         */
        $query = call_user_func($class . "::where", [
            "attribute_id" => $attributeId,
            "goods_id" => $goodsId
        ]);
        $value = $query->first();

        return $value;
    }

}
