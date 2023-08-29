<?php

namespace backend\controllers;

use backend\models\UserForm;
use backend\models\UserSearch;
use backend\modules\rbac\models\Item;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class UserController extends \yii\web\Controller
{
    /**
    * @return array[]
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['user_read'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['user_write']
                    ]
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'auth' => \Yii::$app->authManager
        ]);
    }

    public function actionView(int $id)
    {
        $model = User::findOne($id);

        return $this->render('view', [
            'model' => $model,
            'auth' => \Yii::$app->authManager
        ]);
    }

    public function actionUpdate($id)
    {
        $model = UserForm::findOne($id) ?? throw new NotFoundHttpException();
        $roles = Item::find()->where(['type' => Item::TYPE_ROLE])->all();
        $auth = \Yii::$app->authManager;
        $userRoles = $auth->getRolesByUser($id);

        $model->scenario = UserForm::SCENARIO_UPDATE;

        if (\Yii::$app->request->isPost){
            if ($model->load(\Yii::$app->request->post()) && $model->validate()){
                $model->applyForm();

                $receivedRoles = \Yii::$app->request->post('Roles');
                $oldRoles = $auth->getRolesByUser($model->id);
                foreach ($receivedRoles as $name => $boolVal){
                    // unset common roles
                    if (isset($oldRoles[$name])){
                        unset($oldRoles[$name]);
                        unset($receivedRoles[$name]);
                    } else {
                        //assign new roles
                        $auth->assign($auth->getRole($name), $model->id);
                    }
                    foreach ($oldRoles as $role){
                        // revoke old roles
                        $auth->revoke($role, $model->id);
                    }
                }

                return $this->redirect(['/user/view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'auth' => $auth,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm();
        $roles = Item::find()->where(['type' => Item::TYPE_ROLE])->all();
        $auth = \Yii::$app->authManager;
        $userRoles = [];

        $model->scenario = UserForm::SCENARIO_CREATE;

        if (\Yii::$app->request->isPost){
            if ($model->load(\Yii::$app->request->post()) && $model->validate()){
                $model->applyForm();

                $receivedRoles = \Yii::$app->request->post('Roles');
                foreach ($receivedRoles as $name => $boolVal) {
                    $role = $auth->getRole($name);
                    $auth->assign($role, $model->id);
                }

                return $this->redirect(['/user/view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'auth' => $auth,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

}