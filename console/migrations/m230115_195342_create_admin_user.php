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
        $user = new User();
        $user->username = "admin";
        $user->setPassword("admin");
        $user->email = 'admin@le.shop';
        $user->status = 10;
        $user->generateAuthKey();

        return $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll(['username'=>'admin']);
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
