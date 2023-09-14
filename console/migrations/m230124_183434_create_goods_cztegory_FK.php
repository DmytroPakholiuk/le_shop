<?php

use yii\db\Migration;

/**
 * Class m230124_183434_create_goods_cztegory_FK
 */
class m230124_183434_create_goods_cztegory_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('goods_category',
            'goods',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('goods_category','goods');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230124_183434_create_goods_cztegory_FK cannot be reverted.\n";

        return false;
    }
    */
}
