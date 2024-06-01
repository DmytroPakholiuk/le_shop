<?php

namespace backend\modules\rbac\controllers;

use backend\modules\rbac\models\Item;
use backend\modules\rbac\models\ItemSearch;
use common\helpers\BinaryInsertSortHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\rbac\Role;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `rbac` module
 */
class RoleController extends Controller
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
                        'actions' => ['index', 'get-all-children-permissions'],
                        'allow' => true,
                        'roles' => ['rbac_read'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'get-all-children-permissions'],
                        'allow' => true,
                        'roles' => ['rbac_write']
                    ]
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $model = new Item();
        $model->type = Item::TYPE_ROLE;
        $auth = \Yii::$app->authManager;

        if (\Yii::$app->request->isPost){
            $itemPost = \Yii::$app->request->post('Item');
            $permissionsPost = \Yii::$app->request->post('Permissions');

            $role = $auth->createRole($itemPost['name']);
            $role->description = $itemPost['description'];
            $auth->add($role);

            foreach ($permissionsPost as $name => $value){
                $permission = $auth->getPermission($name);
                $auth->addChild($role, $permission);
            }

            return $this->redirect(Url::to(['/rbac/role/update', 'id' => $role->name]));
        }
        $allPermissions = Item::find()->where(['type' => Item::TYPE_PERMISSION])->orderBy('name')->all();
        return $this->render('create', [
            'model' => $model,
            'permissions' => $allPermissions,
            'user' => \Yii::$app->user,
            'childPermissions' => [],
            'fullPermissions' => [],
        ]);
    }

    public function actionUpdate(string $id)
    {
        $model = Item::findOne(['name' => $id]);
        $auth = \Yii::$app->authManager;
        $childPermissions = $auth->getChildren($model->name);

        if ($model->type == Item::TYPE_PERMISSION) {
            return $this->redirect(['/rbac/permission/update', 'name' => $id]);
        }

        if (\Yii::$app->request->isPost){
            $itemPost = \Yii::$app->request->post('Item');
            $permissionsPost = \Yii::$app->request->post('Permissions');

            $role = $auth->getRole($model->name);
            $role->description = $itemPost['description'];
            $auth->update($model->name, $role);

            $oldChildren = $childPermissions;
            $newChildren = $permissionsPost;
            // we delete the common children to not deal with child assignment
            foreach ($newChildren as $newKey => $newChild){
                if (array_key_exists($newKey, $oldChildren)){
                    unset($oldChildren[$newKey], $newChildren[$newKey]);
                } else {
                    //add new child
                    $auth->addChild($role, $auth->getPermission($newKey));
                }
            }
            //remove all old children that were not sent in POST
            foreach ($oldChildren as $oldChild){
                $auth->removeChild($role, $oldChild);
            }

            $childPermissions = $auth->getChildren($model->name);
        }
        $model->refresh();
        $allPermissions = Item::find()->where(['type' => Item::TYPE_PERMISSION])->orderBy('name')->all();
        return $this->render('update', [
            'model' => $model,
            'permissions' => $allPermissions,
            'user' => \Yii::$app->user,
            'childPermissions' => $childPermissions,
            'fullPermissions' => $auth->getPermissionsByRole($model->name)
        ]);
    }

    /**
     * returns an array of all children of a permission or a permission
     * @param array $names
     * @return \yii\web\Response
     */
    public function actionGetAllChildrenPermissions(array $names)
    {
        $auth = \Yii::$app->authManager;
        $responseArray = [];
        foreach ($names as $name){
            $name = trim($name);
            $item = Item::findOne(['name' => $name]);
            if ($item?->type == Item::TYPE_PERMISSION){
                $responseArray[$name] = ItemSearch::getAllChildren($name);
            } elseif ($item?->type == Item::TYPE_ROLE) {
                $responseArray[$name] = $auth->getPermissionsByRole($name);
            }
        }
        return $this->asJson($responseArray);
    }

    public function actionDelete($id)
    {
        if(!$model = Item::findOne($id)){
            throw new NotFoundHttpException();
        };

        $model->delete();

        return $this->redirect('/rbac/role/index');
    }
}
