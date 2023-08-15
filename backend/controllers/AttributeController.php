<?php

namespace backend\controllers;

use backend\models\AttributeSearch;
use common\models\Attribute;
use common\models\Category;
use common\models\GoodsAttributeDictionaryDefinition;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AttributeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new AttributeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'types' => $searchModel->types()
        ]);
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

    /**
     * @param int $id
     * @param int $goodsId
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionGetCategoryAttributes(int $id, int $goodsId = 0)
    {
        $category = Category::findOne($id) ?? throw new NotFoundHttpException();
        $attributes = Attribute::find()->where(['category_id' => $id])
            ->orWhere(['is', 'category_id', new Expression('null')])->asArray()->all();
        foreach ($attributes as $key => &$attribute){
            if ($attribute['type'] === 'dictionary'){
                if (!empty($attribute['definitions'] = GoodsAttributeDictionaryDefinition::find())){
                    $attribute['definitions'] = GoodsAttributeDictionaryDefinition::find()
                        ->where(['attribute_id' => $attribute['id']])
                        ->asArray()->all();
                } else {
                    unset($attributes[$key]);
                    unset($attribute);
                }
            }

            if ($goodsId && isset($attribute)){
                $attributeValue = Attribute::getValueFor($attribute['id'], $attribute['type'], $goodsId);
                $attribute['value'] = $attributeValue;
            }
        }
        return $this->asJson($attributes);
    }

}