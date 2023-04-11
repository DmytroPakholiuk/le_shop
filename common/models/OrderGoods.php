<?php

namespace common\models;

/**
 * @property int $goods_id
 * @property int $order_id
 * @property-read Goods $goods
 * @property Order $order
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'orders_goods';
    }

    public function rules()
    {
        return [
            [['goods_id', 'order_id'], 'integer'],
            [['goods_id', 'order_id'], 'required'],
        ];
    }
    public static function primaryKey()
    {
        return ['goods_id', "order_id"];
    }

    public function getGoods(){
        return $this->hasOne(Goods::class, ['id' => 'goods_id']);
    }
    public function getOrder(){
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}