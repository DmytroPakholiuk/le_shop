<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_dictionary_definitions}}`.
 */
class m230804_185343_create_attributes_dictionary_definitions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_dictionary_definitions}}', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer(),
            'value' => $this->string(),
        ]);
        $this->addForeignKey(
            'attributes_dictionary_definitions-attributes',
            'attributes_dictionary_definitions',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('attributes_dictionary_definitions-attributes', 'attributes_dictionary_definitions');
        $this->dropTable('{{%attributes_dictionary_definitions}}');
    }
}
