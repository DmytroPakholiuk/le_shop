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
        $auth = Yii::$app->authManager;
        $user = \common\models\User::findOne(['username' => 'admin']);
        $superUser = $auth->getRole('SuperUser');
        $auth->assign($superUser, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $user = \common\models\User::findOne(['username' => 'admin']);
        $superUser = $auth->getRole('SuperUser');
        $auth->revoke($superUser, $user->id);
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
