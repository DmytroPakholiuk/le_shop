<?php

namespace backend\models;

use common\models\DateParser;
use common\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends \common\models\User
{
    use DateParser;

    public array $roles = [];

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'created_at', 'updated_at'], 'string'],
            [['roles'], function($value){
                return is_array($value);
            }]
        ];
    }

    public function search(array $params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            "query" => $query
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        if ($this->status === '0'){
            $query->andWhere(['status' => 0]);
        } else {
            $query->andFilterWhere(['status' => $this->status]);
        }

        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);

        $this->filterDate($this->created_at, 'created_at', $query, true);
        $this->filterDate($this->updated_at, 'updated_at', $query, true);
        //
        return $dataProvider;
    }
}