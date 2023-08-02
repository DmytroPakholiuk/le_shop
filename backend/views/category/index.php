<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\CategorySearch $searchModel
 * @var array $categories
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\web\JsExpression;

$this->title = 'Category List';?>

<h1>Category List</h1>

<?php //echo $this->render('search', ['model' => $searchModel, 'categories' => $categories]);?>

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
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'parent_id',
                    'initValueText' => $searchModel->parent->name ?? '',

//    'data' => $categories,
                    'options' => [
                        'placeholder' => 'Start entering category:',

                    ],
//    'data' => $dataList
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to('category-list'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                    ]
                ]),

                'value' => function(\common\models\Category $model){
                    return $model->parent->name ?? null;
                }
        ],
//        'created_at:datetime',
        [
            'attribute' => 'created_at',
            'filter' => DateRangePicker::widget([
                'language' => 'uk-UK',
                'model' => $searchModel,
                'attribute' => 'created_at',
                'convertFormat' => true,
                'pluginOptions' => [
                    'allowClear' => true,
                    'showDropdowns' => true,
                    'timePicker' => true,
                    'timePicker24Hour' => true,
                    'timePickerIncrement' => 1,
                    'locale' => [
                        'format' => 'Y-m-d H:i:00',
                        'separator' => '--',
                        'applyLabel' => 'Підтвердити',
                        'cancelLabel' => 'Відміна',
                    ],
                    'opens' => 'right',
                ]
            ]),
        ],
        [
                'class' => ActionColumn::class,
        ]
    ]
]); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['category/create']); ?>>Create a new category</a>
