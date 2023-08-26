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
use yii\web\JsExpression;

//var_dump($searchModel->type);die();

$this->title = 'Attribute definition list'; ?>


<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'category_id',
            'label' => 'Category',
            'value' => function(\common\models\Attribute $model) {
                return $model?->category?->name;
            },
            'filter' => \kartik\select2\Select2::widget([
                'model' => $searchModel,
                'attribute' => 'category_id',
                'initValueText' => $searchModel?->category?->name ?? '',
                'options' => [
                    'placeholder' => 'Start entering category:',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to('/category/category-list'),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                ]
            ]),
        ],
        [
            'attribute' => 'type',
            'filter' => $types,
//                Html::dropDownList('AttributeSearch[type]',
//                $searchModel->type,
//                $types,
//                ['class' => 'form-control']
//            ),
            'value' => function(\common\models\Attribute $model) use ($types){
                return $types[$model->type];
            }
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
