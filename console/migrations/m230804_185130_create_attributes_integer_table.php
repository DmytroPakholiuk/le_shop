<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_integer}}`.
 */
class m230804_185130_create_attributes_integer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_integer}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->integer(),
            'is_deleted' => $this->integer()
        ]);
        $this->addForeignKey(
            'attributes_integer-attributes',
            'attributes_integer',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('attributes_integer-goods',
            'attributes_integer',
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
        $this->dropForeignKey('attributes_integer-goods', 'attributes_integer');
        $this->dropForeignKey('attributes_integer-attributes', 'attributes_integer');
        $this->dropTable('{{%attributes_integer}}');
    }
}
