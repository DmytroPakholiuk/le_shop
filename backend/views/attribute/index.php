<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\AttributeSearch $searchModel
 * @var yii\web\View $this
 * @var array $types
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;

//var_dump($searchModel->type);die();

$this->title = 'Attribute definition list'; ?>


<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'category.name',
            'label' => 'Category'
        ],
        [
            'attribute' => 'type',
            'filter' => Html::dropDownList('AttributeSearch[type]',
                $searchModel->type,
                $types,
                ['class' => 'form-control']
            )
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
            'attribute' => 'updated_at',
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
        ]
    ],

]); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['attribute/create']); ?>>Create a new attribute definition</a>
