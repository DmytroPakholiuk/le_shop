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
    /**
     * Attribute definitions by which the search is conducted. For better selection time the
     * attribute definitions are sorted by type like $searchAttributeDefinitions['integer'][25]
     * @var array
     */
    public array $searchValues = [];

    /**
     * ActiveRecord[] array that contains Attribute definitions by which the search is conducted
     * @var array
     */
    private array $searchAttributeDefinitions;

    /**
     * integer array containing ids of matching goods
     * @var array
     */
    public array $goodsIds = [];

    /**
     * contains arrays that represent collections of record arrays. Each such collection is
     * a result of search by one attribute definition. Array structure looks like
     * $searchAttributeValues[$attribute_id][0]['goods_id'] - path to value
     * @var array
     */
    private array $foundAttributeValues = [];

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

    /**
     * populates $this->searchAttributeValues
     * @return void
     */
    private function populateSearchValues(): void
    {
        foreach ($this->searchAttributeDefinitions as $definition){
            // we filter out the 'empty' values to save resources on searching and intersecting search results
            $worthSearching = false;
            switch ($definition->type){
                case Attribute::ATTRIBUTE_TYPE_TEXT:
                    $worthSearching = !empty($this->searchValues[$definition->id]); break;
                case ($definition->type == Attribute::ATTRIBUTE_TYPE_INTEGER || $definition->type == Attribute::ATTRIBUTE_TYPE_FLOAT):
                    $worthSearching = !empty($this->searchValues[$definition->id]['from']) ||
                        !empty($this->searchValues[$definition->id]['to']); break;
                case ($definition->type == Attribute::ATTRIBUTE_TYPE_BOOLEAN || $definition->type == Attribute::ATTRIBUTE_TYPE_DICTIONARY):
                    $worthSearching = !empty($this->searchValues[$definition->id]);
            }
            if ($worthSearching){
                $this->foundAttributeValues[$definition->id] = $this->findValues($definition);
            }
        }
    }

    /**
     * gives an array of ['goods_id'] elements from attribute values that match the search values
     * for that attribute definition
     * @param Attribute $attribute
     * @return array
     */
    private function findValues(Attribute $attribute): array
    {
        switch ($attribute->type){
            case Attribute::ATTRIBUTE_TYPE_TEXT:
                return GoodsAttributeTextValue::find()->select('goods_id')->where(['like', 'value', $this->searchValues[$attribute->id]])
                    ->andWhere(['attribute_id' => $attribute->id])->asArray()->all();
            case Attribute::ATTRIBUTE_TYPE_INTEGER:
                $values = GoodsAttributeIntegerValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if (!empty($this->searchValues[$attribute->id]['from'])){
                    $values->andWhere(['>', 'value', $this->searchValues[$attribute->id]['from']]);
                }
                if (!empty($this->searchValues[$attribute->id]['to'])){
                    $values->andWhere(['<', 'value', $this->searchValues[$attribute->id]['to']]);
                }
                return $values->asArray()->all();
            case Attribute::ATTRIBUTE_TYPE_FLOAT:
                $values = GoodsAttributeFloatValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if (!empty($this->searchValues[$attribute->id]['from'])){
                    $values->andWhere(['>', 'value', $this->searchValues[$attribute->id]['from']]);
                }
                if (!empty($this->searchValues[$attribute->id]['to'])){
                    $values->andWhere(['<', 'value', $this->searchValues[$attribute->id]['to']]);
                }
                return $values->asArray()->all();
            case Attribute::ATTRIBUTE_TYPE_BOOLEAN:
                $values = GoodsAttributeBooleanValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if ($this->searchValues[$attribute->id] != 100){
                    $values->andWhere(['value' => $this->searchValues[$attribute->id]]);
                }
                return $values->asArray()->all();
            case Attribute::ATTRIBUTE_TYPE_DICTIONARY:
                $values = GoodsAttributeDictionaryValue::find()->select('goods_id')->where(['attribute_id' => $attribute->id]);
                if ($this->searchValues[$attribute->id] != 100){
                    $values->andWhere(['value' => $this->searchValues[$attribute->id]]);
                }
                return $values->asArray()->all();
            default:
                throw new InvalidValueException("This Attribute's type is unacceptable ({$attribute->type})");
        }
    }

    /**
     * makes an array of goods ids that match all the searches
     * @return void
     */
    private function pickGoods(): void
    {
        foreach ($this->foundAttributeValues as &$valueCollection){
            $idArray = [];
            foreach ($valueCollection as $value){
                $idArray[] = $value['goods_id'];
            }
            $valueCollection = $idArray;
        }
        if (!empty($this->foundAttributeValues)){
            $this->goodsIds = call_user_func_array('array_intersect', $this->foundAttributeValues);
        }
    }

    /**
     * conducts the search by attributes and applies additional query filters for $dataProvider
     * @param ActiveDataProvider $dataProvider
     * @return void
     */
    public function search(ActiveDataProvider $dataProvider): void
    {
        /**
         * @var Query $query
         */
        $query = $dataProvider->query;
        $this->populateSearchDefinitions();
        $this->populateSearchValues();
        if (!empty($this->foundAttributeValues)){
            $this->pickGoods();
            if (empty($this->goodsIds)){
                //impossible statement
                $query->andFilterWhere(['is', 'id', new Expression('null')]);
            }
            $query->andFilterWhere(['id' => $this->goodsIds]);
        }

//        var_dump($this->goodsIds);die();
    }
}