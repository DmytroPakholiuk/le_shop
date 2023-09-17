<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%attributes_float}}`.
 */
class m230804_184343_create_attributes_float_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attributes_float}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer(),
            'attribute_id' => $this->integer(),
            'value' => $this->float(),
            'is_deleted' => $this->integer()
        ]);
        $this->addForeignKey(
            'attributes_float-attributes',
            'attributes_float',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('attributes_float-goods',
            'attributes_float',
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
        $this->dropForeignKey('attributes_float-goods', 'attributes_float');
        $this->dropForeignKey('attributes_float-attributes', 'attributes_float');
        $this->dropTable('{{%attributes_float}}');
    }
}
