<?php

namespace backend\controllers;

use backend\models\AttributeSearch;
use common\models\Attribute;
use common\models\Category;
use common\models\GoodsAttributeDictionaryDefinition;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AttributeController extends \yii\web\Controller
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
                        'actions' => ['index', 'view', 'get-dictionary-definitions', 'get-category-attributes'],
                        'allow' => true,
                        'roles' => ['attribute_definition_read'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'get-dictionary-definitions', 'get-category-attributes'],
                        'allow' => true,
                        'roles' => ['attribute_definition_write'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AttributeSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'types' => Attribute::getPossibleTypes()
        ]);
    }

    public function actionCreate()
    {
        $model = new Attribute();
        $types = Attribute::getPossibleTypes();

        if (\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post()['Attribute'];
            $model->type = $post['type'];
            $model->name = $post['name'];
            $model->category_id = $post['category_id'];

            if ($model->save()){
                if ($model->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
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
        if ($model->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
            /**
             * @var GoodsAttributeDictionaryDefinition[] $oldDefinitions
             */
            $oldDefinitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        }

        if (\Yii::$app->request->isPost){
            $post = \Yii::$app->request->post()['Attribute'];
            $newDefinitions = null;

            if ($model->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
                /**
                 * @var GoodsAttributeDictionaryDefinition[] $oldDefinitions
                 */
                // we try to find common items in old and new definitions and omit changes to those

                if (isset($post['dictionaryDefinition']) && $post['type'] == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
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

            $model->type = $post['type'];
            $model->name = $post['name'];
            $model->category_id = $post['category_id'];

            if ($model->save()){
                if ($model->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
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


    public function actionDelete($id)
    {
        if(!$model = Attribute::findOne($id)){
            throw new NotFoundHttpException();
        };

        $model->delete();

        return $this->redirect('/attribute/index');
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Attribute::findOne($id);
        $definitions = null;
        if ($model->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
            $definitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        }
        $category = $model->category;
        $types = Attribute::getPossibleTypes();

        return $this->render('view', [
            'model' => $model,
            'definitions' => $definitions,
            'category' => $category,
            'types' => $types
        ]);
    }

    /**
     * returns a json of dictionary definitions for attribute if it is of dictionary type
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionGetDictionaryDefinitions($id)
    {
        $model = Attribute::findOne($id) ?? throw new NotFoundHttpException('attribute not found');
        if ($model->type != Attribute::ATTRIBUTE_TYPE_DICTIONARY){
            throw new NotFoundHttpException('this attribute exists but is not of dictionary type');
        }
        $definitions = GoodsAttributeDictionaryDefinition::find()->where(['attribute_id' => $model->id])->all();
        $definitionMap = ArrayHelper::map($definitions, 'id', 'value');
        return $this->asJson($definitionMap);
    }

    /**
     * returns a json of attributes for a category. Also sends a 'value' field in each attribute if
     * a valid goodsId is provided
     * @param int $id
     * @param int $goodsId
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionGetCategoryAttributes(int $id, int $goodsId = 0)
    {
        $category = Category::findOne($id) ?? null;
        $attributes = Attribute::getAttributesForCategory($category, true);
        foreach ($attributes as $key => &$attribute){
            if ($attribute['type'] == Attribute::ATTRIBUTE_TYPE_DICTIONARY){
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