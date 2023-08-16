<?php

use yii\db\Migration;

/**
 * Class m230804_183644_rename_goods_attributes_to_attributes_text
 */
class m230804_183644_rename_goods_attributes_to_attributes_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('goods_attributes-goods', 'goods_attributes');
        $this->dropForeignKey('goods_attributes-attributes','goods_attributes');
        $this->renameTable('goods_attributes', 'attributes_text');
        $this->addForeignKey(
            'attributes_text-attributes',
            'attributes_text',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'

        );
        $this->addForeignKey('attributes_text-goods',
            'attributes_text',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
        $this->addColumn('attributes_text', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('attributes_text', 'id');
        $this->dropForeignKey('attributes_text-attributes', 'attributes_text');
        $this->renameTable( 'attributes_text', 'goods_attributes');
        $this->addForeignKey('goods_attributes-attributes',
            'goods_attributes',
            'attribute_id',
            'attributes',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('goods_attributes-goods',
            'goods_attributes',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230804_183644_rename_goods_attributes_to_attributes_text cannot be reverted.\n";

        return false;
    }
    */
}
