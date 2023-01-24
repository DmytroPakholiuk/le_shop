<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_goods}}`.
 */
class m230124_171105_create_orders_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders_goods}}', [
            'goods_id' => $this->integer(),
            'order_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders_goods}}');
    }
}
