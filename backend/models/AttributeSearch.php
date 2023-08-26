<?php

namespace backend\models;

use common\models\Attribute;
use common\models\DateParser;
use yii\data\ActiveDataProvider;

class AttributeSearch extends Attribute
{
    use DateParser;

//    public function types()
//    {
//        return array_merge(Attribute::getPossibleTypes(), [100 => '[any]']);
//    }

    public function rules(): array
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'string'],
            [['type'], function($value) {
            // check if value evaluates to element in array
                return (count(self::getPossibleTypes()) > (int)$value) || in_array($value, self::getPossibleTypes());
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

            $dataProvider->query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['category_id' => $this->category_id]);

            $query->andFilterWhere(['type' => $this->type]);


            $this->filterDate($this->created_at, 'created_at', $query);
            $this->filterDate($this->updated_at, 'updated_at', $query);

            return $dataProvider;
        }
    }
}