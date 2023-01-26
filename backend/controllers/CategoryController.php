<?php

namespace backend\controllers;

use common\models\Category;

class CategoryController extends \yii\web\Controller
{


    public function actionIndex(){
        $model = Category::find()->all();

        return $this->render('index',['model' => $model]);
    }
    public function actionView(){

    }

}