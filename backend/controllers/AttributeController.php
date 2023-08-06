<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\GoodsAttributeDictionaryDefinition;

class AttributeController extends \yii\web\Controller
{
    public function actionIndex()
    {

    }

    public function actionCreate()
    {
        $model = new Attribute();
        $types = Attribute::getPossibleTypes();

        if (\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post()['Attribute'];
            $model->type = $types[$post['type']];
            $model->name = $post['name'];
            $model->category_id = $post['category_id'];

            if ($model->save()){
                if ($model->type === 'dictionary'){
                    foreach ($post['dictionaryDefinition'] as $item){
                        $definition = new GoodsAttributeDictionaryDefinition();
                        $definition->attribute_id = $model->id;
                        $definition->value = $item;
                        $definition->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->errors);die();
            }
        }

        return $this->render('create', ['model' => $model, 'types' => $types]);
    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }

    public function actionView()
    {

    }

}