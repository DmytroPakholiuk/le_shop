<?php

use yii\db\Migration;

/**
 * Class m230212_181157_rename_goods_images_table
 */
class m230212_181157_rename_goods_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('pictures', 'goods_images');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable( 'goods_images', 'pictures');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230212_181157_rename_goods_images_table cannot be reverted.\n";

        return false;
    }
    */
}
