<?php

use yii\db\Migration;

/**
 * Class m230821_183258_create_superuser_role
 */
class m230821_183258_create_superuser_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $superUser = $auth->createRole('SuperUser');
        $superUser->description = "This role has all the permissions imaginable";
        $auth->add($superUser);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $superUser = $auth->getRole('SuperUser');
        $auth->remove($superUser);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230821_183258_create_superuser_role cannot be reverted.\n";

        return false;
    }
    */
}
