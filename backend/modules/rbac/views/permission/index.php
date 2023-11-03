<?php


/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\modules\rbac\models\ItemSearch $searchModel
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::t("app/rbac", 'Permission list'); ?>


<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            "attribute" => "name",
            "label" => Yii::t("app/rbac", "name")
        ],
        [
            "attribute" => "rule_name",
            "label" => Yii::t("app/rbac", "rule name")
        ],
        [
            'attribute' => 'created_at',
            "label" => Yii::t("app/rbac", "created at"),
            'format' => 'datetime',
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
            'attribute' => 'updated_at',
            'format' => 'datetime',
            "label" => Yii::t("app/rbac", "updated at"),
            'filter' => DateRangePicker::widget([
                'language' => 'uk-UK',
                'model' => $searchModel,
                'attribute' => 'updated_at',
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
            'template' => '{update}'
        ]
    ],

]); ?>
<br>

