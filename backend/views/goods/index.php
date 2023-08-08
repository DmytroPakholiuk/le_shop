<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\GoodsSearch $searchModel
 * @var yii\web\View $this
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\helpers\Html;

$this->title = 'Goods List';

//$this->registerJsFile('/js/goods-index.js')?>

<?php //echo $this->render('search', ['model' => $searchModel]); ?>

<?php echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
//        'price',
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
        [
            'attribute' => 'category.name',
            'label' => 'Category'
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
<br>
<a href = <?php echo \yii\helpers\Url::to(['goods/create']); ?>>Create a new item</a>
