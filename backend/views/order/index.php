<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\OrderSearch $searchModel
// * @var array $categories
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;

$this->title = Yii::t("app/order", 'Order list');?>

<h1><?= Yii::t("app/order", 'Order list'); ?></h1>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            "attribute" => "sum_price",
            "label" => Yii::t("app/order", "sum price")
        ],
        [
            'label' => Yii::t("app/order", 'status'),
            'attribute' => 'status',
            'value' => function(\common\models\Order $model){
                if ($model->status == 0){
                    return Yii::t("app", 'inactive');
                }
                else{
                    return Yii::t("app", 'active');
                }
            },
            'filter' => [
                0 => Yii::t("app", 'inactive'),
                1 => Yii::t("app", 'active')
            ],
            //'enableSorting' => false,
        ],
        [
            "attribute" => "delivery_address",
            "label" => Yii::t("app/order", "delivery address")
        ],
        [
                'attribute' => 'customer.username',
                'label' => Yii::t("app/order", 'customer')
        ],
        [
            'attribute' => 'created_at',
            "label" => Yii::t("app/order", "created at"),
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
<a href = <?php echo \yii\helpers\Url::to(['/order/create']); ?>><?= Yii::t("app/order", "Create a new order") ?></a>
