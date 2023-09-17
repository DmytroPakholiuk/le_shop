<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_dictionary_values}}`.
 */
class m230804_185355_create_attributes_dictionary_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_dictionary_values}}', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer(),
            'goods_id' => $this->integer(),
            'value_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'attributes_dictionary_values-attributes',
            'attributes_dictionary_values',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('attributes_dictionary_values-goods',
            'attributes_dictionary_values',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('attributes_dictionary_values-attributes_dictionary_definitions',
            'attributes_dictionary_values',
            'value_id',
            'attributes_dictionary_definitions',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%attributes_dictionary_values}}');
    }
}
