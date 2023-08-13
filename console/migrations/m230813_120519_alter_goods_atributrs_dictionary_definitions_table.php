<?php

use yii\db\Migration;

/**
 * Class m230813_120519_alter_goods_atributrs_dictionary_definitions_table
 */
class m230813_120519_alter_goods_atributrs_dictionary_definitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('attributes_dictionary_values', 'value_id', 'value');
        $this->addColumn('attributes_dictionary_values', 'is_deleted', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('value', 'value_id', 'attributes_dictionary_values');
        $this->dropColumn('attributes_dictionary_values', 'is_deleted');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230813_120519_alter_goods_atributrs_dictionary_definitions_table cannot be reverted.\n";

        return false;
    }
    */
}
