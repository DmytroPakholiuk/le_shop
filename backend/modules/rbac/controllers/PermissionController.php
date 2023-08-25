<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\models\Item;
use backend\modules\rbac\models\ItemSearch;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get(), Item::TYPE_PERMISSION);

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionUpdate(string $id)
    {
        $model = Item::findOne($id);
        $auth = \Yii::$app->authManager;
        if ($model->type == Item::TYPE_ROLE) {
            return $this->redirect(['/rbac/role/update', 'name' => $id]);
        }

        if (\Yii::$app->request->isPost){
            $itemPost = \Yii::$app->request->post('Item');
            $perm = $auth->getPermission($id);
            $perm->description = $itemPost['description'];
            $auth->update($id, $perm);
        }
        $model->refresh();
        return $this->render('update', ['model' => $model]);
    }
}