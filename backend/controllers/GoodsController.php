<?php

namespace backend\controllers;

use backend\models\GoodsSearch;
use common\models\Category;
use common\models\Goods;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class GoodsController extends \yii\web\Controller
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
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Goods::findOne($id);

        return $this->render('view', ['model' => $model]);
    }
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Goods();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->author_id = \Yii::$app->user->id;
            $model->save();

            return $this->redirect(['/goods/view', 'id' => $model->id]);
        } else {
            $categories = Category::find()->select('name')->indexBy('id')->column();

            return $this->render('create_form', ['model' => $model, 'categories' => $categories]);
        }
    }
    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = Goods::findOne($id);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->author_id = \Yii::$app->user->id;
            $model->save();

            return $this->redirect(['/goods/view', 'id' => $model->id]);
        } else {
            $categories = Category::find()->select('name')->indexBy('id')->column();

            return $this->render('update_form', ['model' => $model, 'categories' => $categories]);
        }
    }
}
