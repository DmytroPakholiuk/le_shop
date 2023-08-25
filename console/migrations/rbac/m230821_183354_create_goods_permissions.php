<?php

use backend\modules\rbac\rules\GoodsAuthorRule;
use yii\db\Migration;

/**
 * Class m230821_183354_create_goods_permissions
 */
class m230821_183354_create_goods_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
         * the permission tree looks like this:
         *
         * goods_full_access
         * L goods_read
         * L goods_write_any
         *   L goods_create
         *   L goods_update_any
         * L goods_write_own
         *   L [via goodsAuthorRule] goods_update_own
         *     L goods_update_any
         *   L goods_create
         */
        $auth = Yii::$app->authManager;
        $permCreate = $auth->createPermission('goods_create');
        $permCreate->description = 'Permission to create new goods items';
        $permUpdate = $auth->createPermission('goods_update_any');
        $permUpdate->description = 'Permission to update any existing goods item';
        $permUpdateOwn = $auth->createPermission('goods_update_own');
        $permUpdateOwn->description = 'Permission to update/delete only own goods. Author rule is applied';

        $auth->add($permUpdateOwn);
        $auth->add($permUpdate);
        $auth->add($permCreate);

        $auth->addChild($permUpdateOwn, $permUpdate);
        $goodsAuthorRule = new GoodsAuthorRule();
        $permUpdateOwn->ruleName = $goodsAuthorRule->name;
        $auth->add($goodsAuthorRule);
        $auth->update('goods_update_own', $permUpdateOwn);

        $permWrite = $auth->createPermission('goods_write_any');
        $permWrite->description = 'Permission to create and update any goods items';
        $auth->add($permWrite);
        $auth->addChild($permWrite, $permCreate);
        $auth->addChild($permWrite, $permUpdate);

        $permWriteOwn = $auth->createPermission('goods_write_own');
        $permWriteOwn->description = 'Permission to create goods and update own goods';
        $auth->add($permWriteOwn);
        $auth->addChild($permWriteOwn, $permCreate);
        $auth->addChild($permWriteOwn, $permUpdateOwn);

        $permRead = $auth->createPermission('goods_read');
        $permRead->description = 'Permission to view/search/etc for goods';
        $auth->add($permRead);

        $permFull = $auth->createPermission('goods_full_access');
        $permFull->description = 'Permission to do anything with any goods items';
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
        $permCreate = $auth->getPermission('goods_create');
        $permUpdate = $auth->getPermission('goods_update_any');
        $permUpdateOwn = $auth->getPermission('goods_update_own');
        $permRead = $auth->getPermission('goods_read');
        $permWrite = $auth->getPermission('goods_write_any');
        $permWriteOwn = $auth->getPermission('goods_write_own');
        $permFull = $auth->getPermission('goods_full_access');

        $auth->remove($permFull);
        $auth->remove($permRead);
        $auth->remove($permWrite);
        $auth->remove($permWriteOwn);
        $auth->remove($permCreate);
        $auth->remove($permUpdate);
        $auth->remove($permUpdateOwn);

        $authorRule = new GoodsAuthorRule();
        $rule = $auth->getRule($authorRule->name);
        $auth->remove($rule);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230821_183354_create_goods_permissions cannot be reverted.\n";

        return false;
    }
    */
}
