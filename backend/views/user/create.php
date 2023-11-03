<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\User $model
 * @var \yii\rbac\DbManager $auth
 * @var array $roles
 * @var array $userRoles
 */

$this->title = Yii::t("app/user", 'Create a new user'); ?>

<?php echo $this->render('user_form', [
    'model' => $model,
    'auth' => $auth,
    'roles' => $roles,
    'userRoles' => $userRoles
]);



