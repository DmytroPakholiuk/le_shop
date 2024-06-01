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

$this->title = Yii::t("app/goods", 'Goods List');

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
        [
            'attribute' => 'name',
            "label" => Yii::t("app/goods", "name")
        ],
        [
            'attribute' => 'price',
            'label' => Yii::t("app/goods", "price"),
            'filter' =>
                "<div class = 'row'>"
                    . Html::input('text', 'GoodsSearch[price_from]', $searchModel->price_from, [
                            'class' => 'col form-control',
                            'placeholder' => Yii::t("app", 'from'),
                    ])
                    . Html::input('text', 'GoodsSearch[price_to]', $searchModel->price_to, [
                            'class' => 'col form-control',
                            'placeholder' => Yii::t("app", 'to'),
                    ])
                . "</div>"
        ],
        [
            'label' => 'image',
            'format' => 'raw',
            'value' => function(\yii\db\ActiveRecord $model) {
                $layout = "";
//                var_dump($model->images);die();
                if ($model->images) {
                    $layout = "<div><img width='100' height='100' src='/{$model->images[0]->path}'></div>";
                }

                return $layout;
            }
        ],
        [
            'attribute' => 'available',
            "label" => Yii::t("app/goods", "available"),
            'value' => function(\common\models\Goods $model){
                if ($model->available == 0){
                    return Yii::t('app', 'no');
                } else {
                    return Yii::t('app', 'yes');
                }
            },
            'filter' => [0 => Yii::t('app', 'no'), 1 => Yii::t('app', 'yes')],
        ],
//        [
//            'attribute' => 'category.name',
//            'label' => 'Category',
//        ],
        [
            'attribute' => 'category_id',
            'label' => Yii::t("app/goods", "category"),
            'value' => function(\common\models\Goods $model) {
                return $model?->category?->name;
            },
            'filter' => \kartik\select2\Select2::widget([
                'model' => $searchModel,
                'attribute' => 'category_id',
                'initValueText' => $searchModel?->category?->name ?? '',
                'language' => 'uk-UK',
                'options' => [
                    'placeholder' => Yii::t("app/category", 'Start entering category'),
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
            'label' => Yii::t("app/goods", 'author')
        ],
        [
            'attribute' => 'created_at',
            'label' => Yii::t("app/goods", 'created at'),
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
            'label' => Yii::t("app/goods", 'updated at'),
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
<a href = <?php echo \yii\helpers\Url::to(['goods/create']); ?>>
    <button class="btn btn-primary">
        <?= Yii::t("app/goods", "Create a new item") ?>
    </button>
</a>
