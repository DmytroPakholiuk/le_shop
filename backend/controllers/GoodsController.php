<?php

namespace backend\controllers;

use backend\models\GoodsSearch;
use common\models\Attribute;
use common\models\GoodsAttributeValue;
use common\models\Category;
use common\models\Goods;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
                        'actions' => ['create', 'index', 'view', 'update', 'delete-attribute'],
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
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if (!$model->upload()) {
                \Yii::$app->session->setFlash('error', 'could not save images');
            }
            $attributes = \Yii::$app->request->post('goodsAttributes');
            $model->configureAttributes($attributes);
            return $this->redirect(['/goods/view', 'id' => $model->id]);
        }
        $categories = Category::find()->select('name')->indexBy('id')->column();

        return $this->render('create', ['model' => $model, 'categories' => $categories]);

    }
    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = Goods::findOne($id);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if (\Yii::$app->request->post('deleteOldImages')){
                $model->deleteOldImages();
            }
            if (!$model->upload()) {
                \Yii::$app->session->setFlash('error', 'could not save images');
            }
            $attributes = \Yii::$app->request->post('goodsAttributes');
            $model->configureAttributes($attributes);
            return $this->redirect(['/goods/view', 'id' => $model->id]);
        } else {
            $categories = Category::find()->select('name')->indexBy('id')->column();

            return $this->render('update', ['model' => $model, 'categories' => $categories]);
        }
    }

    public function actionDeleteAttribute()
    {
        $goodsId = \Yii::$app->request->post('goodsId');
        $attributeId = \Yii::$app->request->post('attributeId');
        $goodsAttribute = GoodsAttributeValue::findOne(['goods_id' => $goodsId, 'attribute_id' => $attributeId]);
        $goodsAttribute->is_deleted = 1;
        $goodsAttribute->save();

        return $this->asJson([
            'message' => 'Attribute deleted'
        ]);
    }
}
