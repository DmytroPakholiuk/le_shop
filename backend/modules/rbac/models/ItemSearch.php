<?php

namespace backend\modules\rbac\models;

use common\models\DateParser;
use yii\data\ActiveDataProvider;

class ItemSearch extends Item
{
    use DateParser;

    public function rules()
    {
        return [
            [['name', 'rule_name', 'created_at', 'updated_at'], 'string']
        ];
    }

    public static function getAllChildren(string $name): array
    {
        $auth = \Yii::$app->authManager;
        $directChildren = $auth->getChildren($name);
        foreach ($directChildren as $child){
            $directChildren = array_merge($directChildren, self::getAllChildren($child->name));
        }
        return $directChildren;
    }

    public function search(array $params, $type = Item::TYPE_ROLE)
    {
        $query = Item::find();
        $dataProvider = new ActiveDataProvider([
            "query" => $query
        ]);
        $query->andFilterWhere(['type' => $type]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'rule_name', $this->rule_name]);

        $this->filterDate($this->created_at, 'created_at', $query, true);
        $this->filterDate($this->updated_at, 'updated_at', $query, true);
//        //
        return $dataProvider;
    }
}