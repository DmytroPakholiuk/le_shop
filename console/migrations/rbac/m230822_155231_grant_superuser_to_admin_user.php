<?php

use yii\db\Migration;

/**
 * Class m230822_155231_grant_superuser_to_admin_user
 */
class m230822_155231_grant_superuser_to_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand("
            INSERT INTO \"auth_assignment\" (item_name, user_id, created_at)
            values ('SuperUser', 1, 1694036071)
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand("            
            DELETE FROM \"auth_assignment\" WHERE item_name='SuperUser' AND user_id=1
        ")->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230822_155231_grant_superuser_to_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
