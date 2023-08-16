<?php

use yii\db\Migration;

/**
 * Class m230803_181344_alter_attributes_table
 */
class m230803_181344_alter_attributes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('attributes', 'type', $this->string());
        $this->addColumn('attributes', 'category_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('attributes', 'type');
        $this->dropColumn('attributes', 'category_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230803_181344_alter_attributes_table cannot be reverted.\n";

        return false;
    }
    */
}
