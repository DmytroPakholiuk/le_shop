<?php

namespace common\models;
/**
 * An abstract class fit for manipulation of attribute values of any type
 *
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property-read Attribute $attributeDefinition
 * @property-read Goods $goods
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 */
abstract class GoodsAttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @return string|null
     */
    public static function tableName(): ?string
    {
        return null;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id', 'is_deleted'], 'integer'],
            [['attribute_id', 'goods_id'], 'required'],
            [['created_at','updated_at'], 'safe'],
        ];
    }

//    public static function primaryKey()
//    {
//        return ['goods_id', "attribute_id"];
//    }

    public abstract function getValue();
    public function getPresentableValue(): string
    {
        return "{$this->getValue()}";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeDefinition()
    {
        return $this->hasOne(Attribute::class, ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::class, ['id' => 'goods_id']);
    }
}