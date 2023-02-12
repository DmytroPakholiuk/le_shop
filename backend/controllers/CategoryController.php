<?php

namespace backend\controllers;

use backend\models\CategorySearch;
use common\models\Category;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
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
                        'actions' => ['create', 'index', 'view', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
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

        return $this->render('detailed_view', ['category' => $category]);
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

            return $this->render('create_form', ['category' => $category, 'categories' => $categories]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id){
        $category = Category::findOne($id);
        if (\Yii::$app->request->isPost && $category->load(\Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(Url::to(['view', 'id' => $category->id]));
        } else {
            $categories = Category::find()->select('name')->where(['status' => 1])->andWhere(['not', ['id' => $id]])->indexBy('id')->column();

            return $this->render('update_form', ['category' => $category, 'categories' => $categories]);
        }
    }
}
