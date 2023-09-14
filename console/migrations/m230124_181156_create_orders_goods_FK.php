<?php

use yii\db\Migration;

/**
 * Class m230124_181156_create_orders_goods_FK
 */
class m230124_181156_create_orders_goods_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('orders_goods-goods',
            'orders_goods',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('orders_goods-orders',
            'orders_goods',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('orders_goods-goods','orders_goods');
        $this->dropForeignKey('orders_goods-orders','orders_goods');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230124_181156_create_orders_goods_FK cannot be reverted.\n";

        return false;
    }
    */
}
