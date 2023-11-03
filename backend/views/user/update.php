<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\User $model
 * @var \yii\rbac\DbManager $auth
 * @var array $roles
 * @var array $userRoles
 */

$this->title = Yii::t("app/user", 'Update user'); ?>

<h3> <?php
    echo Yii::t("app/user", "User {username}", [
            "username" => $model->username
    ]);
    foreach ($userRoles as $role){
        echo "<div class='badge badge-info' style='margin-left: 10px'>{$role->name}</div>";
    }
    ?></h3>

<?php echo $this->render('user_form', [
    'model' => $model,
    'auth' => $auth,
    'roles' => $roles,
    'userRoles' => $userRoles
]);
