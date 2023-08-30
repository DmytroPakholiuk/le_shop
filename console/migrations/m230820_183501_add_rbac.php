<?php

use yii\db\Migration;

/**
 * Class m230820_183501_add_rbac
 */
class m230820_183501_add_rbac extends Migration
{
    private string $schemaPath = __DIR__ . '/sql/rbac-schema-pgsql.sql';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents($this->schemaPath);
        $this->db->pdo->exec($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = 'drop table if exists "auth_assignment" CASCADE ;
                drop table if exists "auth_item_child" CASCADE ;
                drop table if exists "auth_item" CASCADE ;
                drop table if exists "auth_rule" CASCADE ;';
        $this->db->pdo->exec($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230820_183501_add_rbac cannot be reverted.\n";

        return false;
    }
    */
}
