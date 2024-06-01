<?php

namespace backend\controllers;

use backend\models\CategorySearch;
use common\models\Category;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

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
                        'actions' => ['index', 'view', 'category-list'],
                        'allow' => true,
                        'roles' => ['category_read'],
                    ],
                    [
                        'actions' => ['create', 'update', 'category-list', 'delete'],
                        'allow' => true,
                        'roles' => ['category_write'],
                    ],
                ],
            ],
        ];
    }
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
//        var_dump(\Yii::$app->request->get());die();
        $categories = Category::find()->select('name')->indexBy('id')->column();
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'categories' => $categories]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionView(int $id)
    {
        $category = Category::findOne($id);

        return $this->render('view', ['category' => $category]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $category = new Category();
        if (\Yii::$app->request->isPost && $category->load(\Yii::$app->request->post()) && $category->save()){
            return $this->redirect(Url::to(['view', 'id' => $category->id]));
        } else {
            $categories = Category::find()->select('name')->where(['status' => 1])->indexBy('id')->column();

            return $this->render('create', ['category' => $category, 'categories' => $categories]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id){
        if(!$category = Category::findOne($id)){
            throw new NotFoundHttpException();
        };
        if (\Yii::$app->request->isPost && $category->load(\Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(Url::to(['view', 'id' => $category->id]));
        } else {
            $categories = Category::find()->select('name')->where(['status' => 1])->andWhere(['not', ['id' => $id]])->indexBy('id')->column();

            return $this->render('update', ['category' => $category, 'categories' => $categories]);
        }
    }

    /**
     * @param $q
     * @param $id
     * @return array[]
     */
    public function actionCategoryList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('categories')
                ->where(['like', 'name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Category::find($id)->name];
        }

        return $out;
    }

    public function actionDelete($id)
    {
        if(!$model = Category::findOne($id)){
            throw new NotFoundHttpException();
        };

        $model->delete();

        return $this->redirect('/category/index');
    }
}
