<?php

namespace backend\models;

use common\models\DateParser;
use common\models\Order;
use yii\data\ActiveDataProvider;

class OrderSearch extends \common\models\Order
{
    use DateParser;

    public function rules(): array
    {
        return [
            [['id', 'status', 'delivery_method', 'payment_method', 'customer_id'], 'integer'],
            [['delivery_address'], 'string'],
            [["sum_price"], 'double']
        ];
    }
    public function search(array $params)
    {
        $query = Order::find();
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
        $query->andFilterWhere(['delivery_method' => $this->delivery_method]);
        $query->andFilterWhere(['payment_method' => $this->payment_method]);
        $query->andFilterWhere(['like', 'delivery_address', $this->delivery_address]);

        $this->filterDate($this->created_at, 'created_at', $query);
        //
        return $dataProvider;
    }
}