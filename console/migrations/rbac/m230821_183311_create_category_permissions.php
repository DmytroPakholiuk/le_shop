<?php

use yii\db\Migration;

/**
 * Class m230821_183311_create_category_permissions
 */
class m230821_183311_create_category_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $permWrite = $auth->createPermission('category_write');
        $permWrite->description = 'Permission to create/update categories';

        $permRead = $auth->createPermission('category_read');
        $permRead->description = 'Permission to view/search categories';

        $permFull = $auth->createPermission('category_full_access');
        $permFull->description = 'Permission to do anything with categories';

        $auth->add($permRead);
        $auth->add($permWrite);

        $auth->add($permFull);
        $auth->addChild($permFull, $permWrite);
        $auth->addChild($permFull, $permRead);

        $superUser = $auth->getRole('SuperUser');
        $auth->addChild($superUser, $permFull);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $permWrite = $auth->getPermission('category_write');
        $permRead = $auth->getPermission('category_read');
        $permFull = $auth->getPermission('category_full_access');
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
        echo "m230821_183311_create_category_permissions cannot be reverted.\n";

        return false;
    }
    */
}
