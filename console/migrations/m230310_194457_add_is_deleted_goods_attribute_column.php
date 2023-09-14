<?php

use yii\db\Migration;

/**
 * Class m230310_194457_add_is_deleted_goods_attribute_column
 */
class m230310_194457_add_is_deleted_goods_attribute_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('goods_attributes', 'is_deleted', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('goods_attributes', 'is_deleted');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230310_194457_add_is_deleted_goods_attribute_column cannot be reverted.\n";

        return false;
    }
    */
}
