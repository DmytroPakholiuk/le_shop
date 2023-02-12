<?php

namespace backend\models;

use common\models\Goods;
use yii\data\ActiveDataProvider;

class GoodsSearch extends \common\models\Goods
{
    /**
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['id', 'available', 'category_id', 'author_id'], 'integer'],
            [['name'], 'string'],
            ['price', 'double']
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
                ->andFilterWhere(['category_id' => $this->category_id])
                ->andFilterWhere(['author_id' => $this->author_id]);

            return $dataProvider;
        }
    }
}