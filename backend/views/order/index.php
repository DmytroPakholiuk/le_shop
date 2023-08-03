<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\OrderSearch $searchModel
// * @var array $categories
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;

$this->title = 'Order List';?>

<h1>Category List</h1>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'sum_price',
        [
            'label' => 'status',
            'attribute' => 'status',
            'value' => function(\common\models\Order $model){
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
        'delivery_address',
        [
                'attribute' => 'customer.username',
                'label' => 'customer'
        ],
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
<a href = <?php echo \yii\helpers\Url::to(['/order/create']); ?>>Create a new order</a>
