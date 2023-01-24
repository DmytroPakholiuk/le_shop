<?php

use yii\db\Migration;

/**
 * Class m230124_183257_create_goods_user_FK
 */
class m230124_183257_create_goods_user_FK extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('goods_user',
            'goods',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('goods_user','goods');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230124_183257_create_goods_user_FK cannot be reverted.\n";

        return false;
    }
    */
}
