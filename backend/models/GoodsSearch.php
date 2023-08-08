<?php

namespace backend\models;

use common\models\DateParser;
use common\models\Goods;
use yii\data\ActiveDataProvider;

class GoodsSearch extends \common\models\Goods
{
    use DateParser;

    public string $created_between;

    public $price_from;
    public $price_to;

    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id', 'available', 'category_id', 'author_id'], 'integer'],
            [['name', 'created_between'], 'string'],
            [['price', 'price_from', 'price_to'], 'double']
        ];
    }
    public function search(array $params)
    {
        $query = Goods::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        } else {
            $dataProvider->query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'name', $this->name])
//                ->andFilterWhere(['like', 'price', $this->price])
                ->andFilterWhere(['category_id' => $this->category_id])
//                ->andFilterWhere(['>=', 'price', $this->price_from])
//                ->andFilterWhere(['<=', 'price', $this->price_to])
                ->andFilterWhere(['author_id' => $this->author_id])
                ->andFilterWhere(['available' => $this->available]);

//            $this->filterDate($this->created_between, 'created_at', $query);

            $this->filterDate($this->created_at, 'created_at', $query);
            $this->filterDate($this->updated_at, 'updated_at', $query);

            if (isset($this->price_from, $this->price_to)){
                $dataProvider->query->andFilterWhere(['between', 'price', $this->price_from, $this->price_to]);
            }

            return $dataProvider;
        }
    }
}