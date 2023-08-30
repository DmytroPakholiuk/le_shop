<?php

use yii\db\Migration;

/**
 * Class m230821_183336_create_attribute_permissions
 */
class m230821_183336_create_attribute_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $permRead = $auth->createPermission('attribute_definition_read');
        $permRead->description = 'Permission to view/search attribute definitions';
        $permWrite = $auth->createPermission('attribute_definition_write');
        $permWrite->description = 'Permission to create/update attribute definitions';

        $auth->add($permWrite);
        $auth->add($permRead);

        $permFull = $auth->createPermission('attribute_definition_full_access');
        $permFull->description = 'Permission to do all CRUD operations with attribute definitions';
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
        $permWrite = $auth->getPermission('attribute_definition_write');
        $permFull = $auth->getPermission('attribute_definition_full_access');
        $permRead = $auth->getPermission('attribute_definition_read');
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
        echo "m230821_183336_create_attribute_permissions cannot be reverted.\n";

        return false;
    }
    */
}
