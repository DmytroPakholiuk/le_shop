<?php

namespace backend\models;

use common\models\Category;
use common\models\DateParser;
use frontend\tests\functional\ContactCest;
use yii\data\ActiveDataProvider;

class CategorySearch extends \common\models\Category
{
    use DateParser;

    public $created_between;
    public $created_before;
    public $created_after;

    public function rules()
    {
        return [
            [['id', 'status', 'parent_id'], 'integer'],
            [['name', 'created_at', 'updated_at', 'description', 'created_between'], 'string'],
        ];
    }
    public function search(array $params)
    {
        $query = Category::find();
        $dataProvider = new ActiveDataProvider([
            "query" => $query
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        if ($this->status === '0'){
            $query->andWhere(['status' => 0]);
        }
        else{
            $query->andFilterWhere(['status' => $this->status]);
        }
        $query->andFilterWhere(['parent_id' => $this->parent_id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        if ($this->created_between){
            $this->created_before = $this->parseTime($this->created_between)[0];
            $this->created_after = $this->parseTime($this->created_between)[1];

            $query->andFilterWhere(['>=', 'created_at', $this->created_before]);
            $query->andFilterWhere(['<=', 'created_at', $this->created_after]);
        }
        //
        return $dataProvider;
    }
}