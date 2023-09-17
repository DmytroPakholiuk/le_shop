<?php

use yii\db\Migration;

/**
 * Class m230914_073202_alter_attribute_values_PKs
 */
class m230914_073202_alter_attribute_values_PKs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropPrimaryKey('attributes_text_pkey', 'attributes_text');
        $this->dropPrimaryKey('attributes_integer_pkey', 'attributes_integer');
        $this->dropPrimaryKey('attributes_float_pkey', 'attributes_float');
        $this->dropPrimaryKey('attributes_boolean_pkey', 'attributes_boolean');
        $this->dropPrimaryKey('attributes_dictionary_values_pkey', 'attributes_dictionary_values');

        $this->dropColumn('attributes_text', 'id');
        $this->dropColumn('attributes_integer', 'id');
        $this->dropColumn('attributes_float', 'id');
        $this->dropColumn('attributes_boolean', 'id');
        $this->dropColumn('attributes_dictionary_values', 'id');

        $this->addPrimaryKey('attributes_text_pkey', 'attributes_text', ['goods_id', 'attribute_id']);
        $this->addPrimaryKey('attributes_integer_pkey', 'attributes_integer', ['goods_id', 'attribute_id']);
        $this->addPrimaryKey('attributes_float_pkey', 'attributes_float', ['goods_id', 'attribute_id']);
        $this->addPrimaryKey('attributes_boolean_pkey', 'attributes_boolean', ['goods_id', 'attribute_id']);
        $this->addPrimaryKey('attributes_dictionary_values_pkey', 'attributes_dictionary_values', ['goods_id', 'attribute_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('attributes_text_pkey', 'attributes_text');
        $this->dropPrimaryKey('attributes_integer_pkey', 'attributes_integer');
        $this->dropPrimaryKey('attributes_float_pkey', 'attributes_float');
        $this->dropPrimaryKey('attributes_boolean_pkey', 'attributes_boolean');
        $this->dropPrimaryKey('attributes_dictionary_values_pkey', 'attributes_dictionary_values');

        $this->addColumn('attributes_text', 'id', $this->primaryKey());
        $this->addColumn('attributes_integer', 'id', $this->primaryKey());
        $this->addColumn('attributes_float', 'id', $this->primaryKey());
        $this->addColumn('attributes_boolean', 'id', $this->primaryKey());
        $this->addColumn('attributes_dictionary_values', 'id', $this->primaryKey());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230914_073202_alter_attribute_values_PKs cannot be reverted.\n";

        return false;
    }
    */
}
