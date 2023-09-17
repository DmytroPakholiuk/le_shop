<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_boolean}}`.
 */
class m230804_185207_create_attributes_boolean_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_boolean}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->boolean(),
            'is_deleted' => $this->integer()
        ]);
        $this->addForeignKey(
            'attributes_boolean-attributes',
            'attributes_boolean',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('attributes_boolean-goods',
            'attributes_boolean',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('attributes_boolean-goods', 'attributes_boolean');
        $this->dropForeignKey('attributes_boolean-attributes', 'attributes_boolean');
        $this->dropTable('{{%attributes_boolean}}');
    }
}
