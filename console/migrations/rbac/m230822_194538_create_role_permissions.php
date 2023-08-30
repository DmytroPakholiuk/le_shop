<?php

use yii\db\Migration;

/**
 * Class m230822_194538_create_role_permissions
 */
class m230822_194538_create_role_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $permRead = $auth->createPermission('rbac_read');
        $permRead->description = 'Permission to view/search rbac roles and permissions';
        $permWrite = $auth->createPermission('rbac_write');
        $permWrite->description = 'Permission to create/update rbac roles and permissions';

        $auth->add($permWrite);
        $auth->add($permRead);

        $permFull = $auth->createPermission('rbac_full_access');
        $permFull->description = 'Permission to do all CRUD operations with rbac roles and permissions';
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
        $permWrite = $auth->getPermission('rbac_write');
        $permFull = $auth->getPermission('rbac_full_access');
        $permRead = $auth->getPermission('rbac_read');
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
        echo "m230822_194538_create_role_permissions cannot be reverted.\n";

        return false;
    }
    */
}
