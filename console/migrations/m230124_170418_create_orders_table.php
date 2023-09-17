<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m230124_170418_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'sum_price' => $this->float(2),

            'payment_method' => $this->integer(),
            'delivery_method' => $this->integer(),//these two might be changed later

            'status' => $this->integer(),
            'delivery_address' => $this->text(),
            'customer_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp()->defaultValue('NOW()'),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
