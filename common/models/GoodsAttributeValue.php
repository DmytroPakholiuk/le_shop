<?php

namespace common\models;
/**
 * An abstract class fit for manipulation of attribute values of any type
 *
 * @property integer $id
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property-read Attribute $attributeDefinition
 * @property-read Goods $goods
 * @property string $created_at
 * @property string $updated_at
// * @property int $is_deleted
 */
abstract class GoodsAttributeValue extends \yii\db\ActiveRecord
{

    /**
     * It should return the name of the attribute type this class is of.
     * @return string
     */
    public abstract static function getTypeName(): string;

    /**
     * @return string|null
     */
    public static function tableName(): ?string
    {
        return null;
    }

    /**
     * @param $asArray
     * @return string[]
     *
     * the PK of attribute values is defined by a combination of goods_id of goods it belongs to
     * and attribute_id of attribute definition it represents
     */
    public static function primaryKey($asArray = false)
    {
        return ['goods_id', 'attribute_id'];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'attribute_id'], 'integer'],
            [['attribute_id', 'goods_id'], 'required'],
            [['created_at','updated_at'], 'safe'],
            ['goods_id', 'exist', 'targetClass' => Goods::class, 'targetAttribute' => ['goods_id' => 'id']],
            ['attribute_id', 'exist', 'targetClass' => Attribute::class, 'targetAttribute' => ['attribute_id' => 'id']],
        ];
    }

    public function beforeValidate()
    {
        $count = static::find()->where([
            'attribute_id' => $this->attribute_id,
            'goods_id' => $this->goods_id
        ])->count();

        return $this->isNewRecord ? $count < 1 : $count == 1;
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