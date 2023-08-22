<?php

namespace backend\modules\rbac\controllers;

use yii\web\Controller;

/**
 * Default controller for the `rbac` module
 */
class RoleController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCanI(string $permission)
    {
        $auth = \Yii::$app->authManager;
        var_dump(\Yii::$app->user->can($permission));die();
    }

}
