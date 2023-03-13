<?php

use yii\db\Migration;

/**
 * Class m230218_144916_drop_value_column_attributes
 */
class m230218_144916_drop_value_column_attributes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('attributes', 'value');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('attributes', 'value', $this->string());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230218_144916_drop_value_column_attributes cannot be reverted.\n";

        return false;
    }
    */
}
