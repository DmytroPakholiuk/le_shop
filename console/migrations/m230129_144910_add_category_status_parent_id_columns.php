<?php

use yii\db\Migration;

/**
 * Class m230129_144910_add_category_status_parent_id_columns
 */
class m230129_144910_add_category_status_parent_id_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('categories', 'status', $this->smallInteger()->defaultValue(1));
        $this->addColumn('categories', 'parent_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('categories', 'parent_id');
        $this->dropColumn('categories', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230129_144910_add_category_status_parent_id_columns cannot be reverted.\n";

        return false;
    }
    */
}
