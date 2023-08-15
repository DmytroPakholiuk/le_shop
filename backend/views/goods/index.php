<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\GoodsSearch $searchModel
 * @var yii\web\View $this
 * @var \common\models\Attribute[] $attributeDefinitions
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->title = 'Goods List';

//$this->registerJsFile('/js/goods-index.js')?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<?php echo $this->render('search', ['model' => $searchModel, 'attributeDefinitions' => $attributeDefinitions, 'form' => $form]); ?>



<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'price',
            'filter' =>
                "<div class = 'row'>"
                    . Html::input('text', 'GoodsSearch[price_from]', $searchModel->price_from, [
                            'class' => 'col form-control',
                            'placeholder' => 'from',
                    ])
                    . Html::input('text', 'GoodsSearch[price_to]', $searchModel->price_to, [
                            'class' => 'col form-control',
                            'placeholder' => 'to'
                    ])
                . "</div>"
        ],
        [
            'attribute' => 'available',
            'value' => function(\common\models\Goods $model){
                if ($model->available == 0){
                    return 'No';
                } else {
                    return 'Yes';
                }
            },
            'filter' => Html::dropDownList('GoodsSearch[available]', $searchModel->available,
                [0 => 'No', 1 => 'Yes'], ['class' => 'form-control'])
        ],
//        [
//            'attribute' => 'category.name',
//            'label' => 'Category',
//        ],
        [
            'attribute' => 'category_id',
            'label' => 'Category',
            'value' => function(\common\models\Goods $model) {
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
            'attribute' => 'author.username',
            'label' => 'Author'
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

<?php ActiveForm::end(); ?>
<br>
<a href = <?php echo \yii\helpers\Url::to(['goods/create']); ?>>Create a new item</a>
