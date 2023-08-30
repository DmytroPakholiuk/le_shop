<?php

use yii\db\Migration;

/**
 * Class m230829_155350_create_user_permissions
 */
class m230829_155350_create_user_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $permRead = $auth->createPermission('user_read');
        $permRead->description = 'Permission to view/search user profiles';
        $permWrite = $auth->createPermission('user_write');
        $permWrite->description = 'Permission to create/update user profiles';

        $auth->add($permWrite);
        $auth->add($permRead);

        $permFull = $auth->createPermission('user_full_access');
        $permFull->description = 'Permission to do all CRUD operations with user profiles';
        $auth->add($permFull);

        $auth->addChild($permFull, $permRead);
        $auth->addChild($permFull, $permWrite);

        $superUser = $auth->getRole('SuperUser');
        $auth->addChild($superUser, $permFull);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $permWrite = $auth->getPermission('user_write');
        $permFull = $auth->getPermission('user_full_access');
        $permRead = $auth->getPermission('user_read');
        $auth->remove($permFull);
        $auth->remove($permRead);
        $auth->remove($permWrite);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230829_155350_create_user_permissions cannot be reverted.\n";

        return false;
    }
    */
}
