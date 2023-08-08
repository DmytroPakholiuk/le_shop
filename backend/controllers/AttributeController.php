<?php

namespace backend\controllers;

use common\models\Attribute;
use common\models\GoodsAttributeDictionaryDefinition;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

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

        return $this->render('create', ['model' => $model, 'types' => $types, 'definitions' => null]);
    }

    public function actionUpdate(int $id)
    {
        if(!$model = Attribute::findOne($id)){
            throw new NotFoundHttpException();
        };
        $types = Attribute::getPossibleTypes();
        $oldDefinitions = null;
        if ($model->type === 'dictionary'){
            /**
             * @var GoodsAttributeDictionaryDefinition[] $oldDefinitions
             */
            $oldDefinitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        }

        if (\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post()['Attribute'];
            $newDefinitions = null;

            if ($model->type === 'dictionary'){
                /**
                 * @var GoodsAttributeDictionaryDefinition[] $oldDefinitions
                 */
                // we try to find common items in old and new definitions and omit changes to those

                if (isset($post['dictionaryDefinition']) && $types[$post['type']] === 'dictionary'){
                    $newDefinitions = $post['dictionaryDefinition'];
                } else {
                    $newDefinitions = [];
                }

                foreach ($oldDefinitions as $defKey => $oldDefinition){
                    if (($key = array_search($oldDefinition->value, $newDefinitions)) !== false){
                        unset($newDefinitions[$key]);
                        unset($oldDefinitions[$defKey]);
                    } else {
                        $oldDefinition->delete();
                    }
                }
            }

            $model->type = $types[$post['type']];
            $model->name = $post['name'];
            $model->category_id = $post['category_id'];

            if ($model->save()){
                if ($model->type === 'dictionary'){
                    foreach ($newDefinitions as $item){
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

        return $this->render('update', ['model' => $model, 'types' => $types, 'definitions' => $oldDefinitions]);
    }

    public function actionDelete()
    {

    }

    public function actionView($id)
    {
        $model = Attribute::findOne($id);
        $definitions = null;
        if ($model->type === 'dictionary'){
            $definitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        }
        $category = $model->category;

        return $this->render('view', ['model' => $model, 'definitions' => $definitions, 'category' => $category]);
    }

    public function actionGetDictionaryDefinitions($id)
    {
        $model = Attribute::findOne($id) ?? throw new NotFoundHttpException();
        if ($model->type !== 'dictionary'){
            throw new NotFoundHttpException();
        }
        $definitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        $definitionMap = ArrayHelper::map($definitions, 'id', 'value');
        return $this->asJson($definitionMap);
    }

}