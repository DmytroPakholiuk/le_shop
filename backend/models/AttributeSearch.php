<?php

namespace backend\models;

use common\models\Attribute;
use common\models\DateParser;
use yii\data\ActiveDataProvider;

class AttributeSearch extends Attribute
{
    use DateParser;

    public function types()
    {
        return array_merge(Attribute::getPossibleTypes(), ['[any]']);
    }

    public function rules(): array
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'string'],
            [['type'], function($value) {
            // check if value evaluates to element in array
                return (count($this->types()) > (int)$value) || in_array($value, $this->types());
            }]
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        $query = Attribute::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        } else {
            // transform type if it arrived as int
            if (count($this->types()) > (int)$this->type){
                $this->type = $this->types()[$this->type];
            }

            $dataProvider->query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['category_id' => $this->category_id]);

            if ($this->type !== '[any]'){
                $query->andFilterWhere(['type' => $this->type]);
            }

            $this->filterDate($this->created_at, 'created_at', $query);
            $this->filterDate($this->updated_at, 'updated_at', $query);

            return $dataProvider;
        }
    }
}