<?php

namespace backend\models;

use common\models\Attribute;
use common\models\GoodsAttributeBooleanValue;
use common\models\GoodsAttributeDictionaryValue;
use common\models\GoodsAttributeFloatValue;
use common\models\GoodsAttributeIntegerValue;
use common\models\GoodsAttributeTextValue;
use yii\base\InvalidValueException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\db\QueryInterface;

class AttributeValueSearch extends Model
{
    public array $searchValues = [];

    /**
     * Attribute definitions by which the search is conducted. For better selection time the
     * attribute definitions are sorted by type like $searchAttributeDefinitions['integer'][25]
     * @var array
     */
    public array $searchAttributeDefinitions;

    public array $goodsIds;

    public array $searchAttributeValues;

    /**
     * Populates $searchAttributeDefinitions based on $this->$searchValues which has to be populated beforehand
     * @return void
     */
    private function populateSearchDefinitions(): void
    {
        /**
         * @var Attribute[] $searchAttributeDefinitions
         */
        $this->searchAttributeDefinitions = Attribute::find()->where(['id' => array_keys($this->searchValues)])->all();
//        foreach ($searchAttributeDefinitions as $attributeDefinition){
//            $this->searchAttributeDefinitions[$attributeDefinition->type][$attributeDefinition->id] = $attributeDefinition;
//        }
    }

    private function populateSearchValues()
    {
        foreach ($this->searchAttributeDefinitions as $definition){
            $this->searchAttributeValues[$definition->id] = $this->findValues($definition);
        }
    }

    private function findValues(Attribute $attribute): array
    {
        switch ($attribute->type){
            case 'text':
                return GoodsAttributeTextValue::find()->select('goods_id')->where(['like', 'value', $this->searchValues[$attribute->id]])
                    ->andWhere(['attribute_id' => $attribute->id])->asArray()->all();
            case 'integer':
                $values = GoodsAttributeIntegerValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if (!empty($this->searchValues[$attribute->id]['from'])){
                    $values->andWhere(['>', 'value', $this->searchValues[$attribute->id]['from']]);
                }
                if (!empty($this->searchValues[$attribute->id]['to'])){
                    $values->andWhere(['<', 'value', $this->searchValues[$attribute->id]['to']]);
                }
                return $values->asArray()->all();
            case 'float':
                $values = GoodsAttributeFloatValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if (!empty($this->searchValues[$attribute->id]['from'])){
                    $values->andWhere(['>', 'value', $this->searchValues[$attribute->id]['from']]);
                }
                if (!empty($this->searchValues[$attribute->id]['to'])){
                    $values->andWhere(['<', 'value', $this->searchValues[$attribute->id]['to']]);
                }
                return $values->asArray()->all();
            case 'boolean':
                return GoodsAttributeBooleanValue::find()->select('goods_id')
                    ->where(['value' => $this->searchValues[$attribute->id]])
                    ->andWhere(['attribute_id' => $attribute->id])->asArray()->all();
            case 'dictionary':
                return GoodsAttributeDictionaryValue::find()->select('goods_id')
                    ->where(['value' => $this->searchValues[$attribute->id]])
                    ->andWhere(['attribute_id' => $attribute->id])->asArray()->all();
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$attribute->type})");
        }
    }

    private function pickGoods()
    {
        foreach ($this->searchAttributeValues as &$valueCollection){
            $idArray = [];
            foreach ($valueCollection as $value){
                $idArray[] = $value['goods_id'];
            }
            $valueCollection = $idArray;
        }
        $this->goodsIds = call_user_func_array('array_intersect', $this->searchAttributeValues);
    }

    public function search(ActiveDataProvider $dataProvider)
    {
        /**
         * @var Query $query
         */
        $query = $dataProvider->query;
        $this->populateSearchDefinitions();
        $this->populateSearchValues();
        $this->pickGoods();
        if (empty($this->goodsIds)){
            //impossible statement
            $query->andFilterWhere(['is', 'id', new Expression('null')]);
        }
        $query->andFilterWhere(['id' => $this->goodsIds]);
//        var_dump($this->goodsIds);die();
    }
}