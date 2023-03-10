<?php

namespace common\models;
/**
 * @property string $value
 * @property integer $goods_id
 * @property integer $attribute_id
 * @property-read Attribute $attributeDefinition
 * @property-read Goods $goods
 * @property string $created_at
 * @property string $updated_at
 */
class GoodsAttributeValue extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'goods_attributes';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['goods_id', 'attribute_id'], 'integer'],
            ['value', 'string'],
            [['created_at','updated_at'], 'safe'],
        ];
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