<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\GoodsSearch $searchModel
 * @var yii\web\View $this
 */

$this->title = 'Goods List';?>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        'price',
        [
            'attribute' => 'available',
            'value' => function(\common\models\Goods $model){
                if ($model->available == 0){
                    return 'No';
                } else {
                    return 'Yes';
                }
            }
        ],
        [
            'attribute' => 'category.name',
            'label' => 'Category'
        ],
        [
            'attribute' => 'author.username',
            'label' => 'Author'
        ],
        'created_at:datetime',
        'updated_at:datetime'

    ]
]); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['goods/create']); ?>>Create a new item</a>
