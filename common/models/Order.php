<?php

namespace common\models;

/**
 * @property int $id
 * @property float $sum_price
 * @property int $payment_method
 * @property int $delivery_method
 * @property int $status
 * @property int $customer_id
 * @property string $delivery_address
 *
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Goods[] $goods
 * @property-read User $customer
 */
class Order extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['id', 'payment_method', 'delivery_method', 'status', 'customer_id'], 'integer'],
            [['delivery_address'], 'string'],
            [['sum_price'], 'double']
        ];
    }

    public function getGoods(){
        return $this->hasMany(Goods::class, ['id' => 'goods_id'])->viaTable('orders_goods', ['order_id' => 'id']);
    }

    public function getCustomer(){
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }
}