<?php

use yii\db\Migration;

/**
 * Class m230124_183100_create_order_user_FK
 */
class m230124_183100_create_order_user_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('order_user',
            'orders',
            'customer_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('order_user','orders');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230124_183100_create_order_user_FK cannot be reverted.\n";

        return false;
    }
    */
}
