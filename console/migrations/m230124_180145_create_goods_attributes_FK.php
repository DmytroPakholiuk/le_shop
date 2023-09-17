<?php

use yii\db\Migration;

/**
 * Class m230124_180145_create_goods_attributes_FK
 */
class m230124_180145_create_goods_attributes_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('goods_attributes-goods',
            'goods_attributes',
            'goods_id',
            'goods',
            'id',
            'CASCADE'
        );
        $this->addForeignKey('goods_attributes-attributes',
            'goods_attributes',
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
        $this->dropForeignKey('goods_attributes-goods','goods_attributes');
        $this->dropForeignKey('goods_attributes-attributes','goods_attributes');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230124_180145_create_goods_attributes_FK cannot be reverted.\n";

        return false;
    }
    */
}
