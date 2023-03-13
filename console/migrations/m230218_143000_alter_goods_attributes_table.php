<?php

use yii\db\Migration;

/**
 * Class m230218_143000_alter_goods_attributes_table
 */
class m230218_143000_alter_goods_attributes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('goods_attributes', 'value', $this->string());
        $attributes = (new \yii\db\Query())->from('attributes')->select('value')->indexBy('id')->column();
        foreach ($attributes as $id => $value){
            $this->update('goods_attributes', ['value' => $value], ['attribute_id' => $id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('goods_attributes', 'value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230218_143000_alter_goods_attributes_table cannot be reverted.\n";

        return false;
    }
    */
}
