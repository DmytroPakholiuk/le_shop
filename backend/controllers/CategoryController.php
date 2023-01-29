<?php

namespace backend\controllers;

use common\models\Category;
use yii\helpers\Url;
use yii\web\Controller;

class CategoryController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = Category::find()->all();

        return $this->render('index', ['model' => $model]);
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

            return $this->render('create_form', ['category' => $category, 'categories' => $categories]);
        }
    }
}
