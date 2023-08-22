<?php

namespace backend\modules\rbac\rules;

use common\models\User;

class GoodsAuthorRule extends \yii\rbac\Rule
{

    public $name = 'goodsAuthorRule';

    /**
     * @inheritDoc
     */
    public function execute($user, $item, $params): bool
    {
        return isset($params['goods']) && $params['goods']->author_id == $user;
    }
}