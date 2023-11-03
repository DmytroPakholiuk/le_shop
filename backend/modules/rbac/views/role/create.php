<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\rbac\models\Item $model
 * @var \backend\modules\rbac\models\Item[] $permissions
 * @var \yii\web\User $user
 * @var array $childPermissions
 * @var array $fullPermissions
 */

$this->title = Yii::t("app/rbac", 'Create a new role'); ?>

<?php echo $this->render('role_form', [
    'model' => $model,
    'permissions' => $permissions,
    'user' => $user,
    'childPermissions' => $childPermissions,
    'fullPermissions' => $fullPermissions
]);
