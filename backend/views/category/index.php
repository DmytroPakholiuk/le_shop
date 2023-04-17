<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\CategorySearch $searchModel
 * @var array $categories
 * @var yii\web\View $this
 */

use yii\grid\ActionColumn;

$this->title = 'Category List';?>

<h1>Category List</h1>

<?php echo $this->render('search', ['model' => $searchModel, 'categories' => $categories]);?>

<?php echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
            'id',
        'name',
        'description',
        [
                'label' => 'status',
                'attribute' => 'status',
                'value' => function(\common\models\Category $model){
                    if ($model->status == 0){
                        return 'inactive';
                    }
                    else{
                        return 'active';
                    }
                },
                'filter' => [
                        0 => 'inactive',
                        1 => 'active'
                ],
                //'enableSorting' => false,
        ],
        [
                'attribute' => 'parent_id',
                'filter' => $categories,
                'value' => function(\common\models\Category $model){
                    return $model->parent->name ?? null;
                }
        ],
        'created_at:datetime',
        [
                'class' => ActionColumn::class,
        ]
    ]
]); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['category/create']); ?>>Create a new category</a>
