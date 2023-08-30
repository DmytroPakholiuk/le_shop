<?php

namespace backend\models;

use common\models\DateParser;
use common\models\Goods;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

class GoodsSearch extends \common\models\Goods
{
    use DateParser;

    public AttributeValueSearch $attributeValueSearch;

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
            [['name'], 'string'],
            [['price', 'price_from', 'price_to'], 'double'],
            [['created_at', 'updated_at'], 'string']
//            [['category.name'], 'safe']
        ];
    }

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->attributeValueSearch = new AttributeValueSearch();
    }

    public function search(array $params): ActiveDataProvider
    {
//        var_dump(Html::getAttributeName("searchValues[1]"));
//        var_dump($params);die();

        $query = Goods::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        } else {
            if (isset($params['AttributeValueSearch']['searchValues'])) {
                $this->attributeValueSearch->searchValues = $params['AttributeValueSearch']['searchValues'];
                $this->attributeValueSearch->search($dataProvider);
            }
            $dataProvider->query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['category_id' => $this->category_id])
//                ->andFilterWhere(['>=', 'price', $this->price_from])
//                ->andFilterWhere(['<=', 'price', $this->price_to])
                ->andFilterWhere(['author_id' => $this->author_id]);

            $dataProvider->query->andFilterWhere(['available' => $this->available]);

//            $this->filterDate($this->created_between, 'created_at', $query);
            $this->filterDate($this->created_at, 'created_at', $query);
            $this->filterDate($this->updated_at, 'updated_at', $query);

            if (isset($this->price_from)){
                $dataProvider->query->andFilterWhere(['>', 'price', $this->price_from]);
            }
            if (isset($this->price_to)){
                $dataProvider->query->andFilterWhere(['<', 'price', $this->price_to]);
            }

            return $dataProvider;
        }
    }
}