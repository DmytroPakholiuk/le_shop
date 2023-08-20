<?php

use yii\db\Migration;

/**
 * Class m230820_115119_alter_attribute_tables
 */
class m230820_115119_alter_attribute_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //pgsql syntax because automatic casting between integer and varchar not allowed
        $this->execute('ALTER TABLE "attributes" ALTER COLUMN "type" TYPE integer USING type::integer,
            ALTER COLUMN "type" DROP DEFAULT, ALTER COLUMN "type" DROP NOT NULL');
//        $this->alterColumn('attributes', 'type', $this->integer());
        $this->dropColumn('attributes_dictionary_values', 'is_deleted');
        $this->dropColumn('attributes_float', 'is_deleted');
        $this->dropColumn('attributes_integer', 'is_deleted');
        $this->dropColumn('attributes_boolean', 'is_deleted');
        $this->dropColumn('attributes_text', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('attributes', 'type', $this->string());
        $this->addColumn('attributes_dictionary_values', 'is_deleted', $this->integer());
        $this->addColumn('attributes_float', 'is_deleted', $this->integer());
        $this->addColumn('attributes_integer', 'is_deleted', $this->integer());
        $this->addColumn('attributes_boolean', 'is_deleted', $this->integer());
        $this->addColumn('attributes_text', 'is_deleted', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230820_115119_alter_attribute_tables cannot be reverted.\n";

        return false;
    }
    */
}
