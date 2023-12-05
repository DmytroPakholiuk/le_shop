<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m230115_195342_create_admin_user
 */
class m230115_195342_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $user = new User();
//        $user->username = "admin";
//        $user->setPassword("admin");
//        $user->email = 'admin@le.shop';
//        $user->status = 10;
//        $user->generateAuthKey();
//
//        return $user->save();

        Yii::$app->db->createCommand("
            INSERT INTO \"user\" (id, username, auth_key, password_hash, email, status, created_at, updated_at)
            values (1, 'admin', :authKey, :passwordHash, 'admin@le.shop', 10, 1694506943, 1694506943)
        ", [
            "authKey" => Yii::$app->security->generateRandomString(),
            "passwordHash" => Yii::$app->security->generatePasswordHash("admin")
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand("
            DELETE FROM user WHERE id=1
        ", [
            "authKey" => Yii::$app->security->generateRandomString(),
            "passwordHash" => Yii::$app->security->generatePasswordHash("admin")
        ])->execute();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230115_195342_create_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
