<?php

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\UserSearch $searchModel
 * @var yii\web\View $this
 * @var \yii\rbac\DbManager $auth
 */

use kartik\daterange\DateRangePicker;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

$this->title = Yii::t("app/user", 'User list'); ?>

<?php //var_dump($searchModel->roles); die(); ?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        [
            "label" => Yii::t("app/user", "username"),
            "attribute" => 'username',
        ],
        [
            "label" => Yii::t("app/user", "email"),
            "attribute" => 'email',
        ],
        [
            'label' => Yii::t("app/user", "roles"),
            'value' => function(\common\models\User $model) use ($auth){
                $roles = $auth->getRolesByUser($model->id);
                $value = '';
                foreach ($roles as $role){
                    $value .= "<div class='badge badge-info' style='margin-right: 10px'>{$role->name}</div>";
                }
                return $value;
            },
            'filter' => false,
//                \kartik\select2\Select2::widget([
//                'name' => 'UserSearch[roles]',
//                'options' => [
//                    'placeholder' => 'Start entering roles:',
//                    'multiple' => true
//                ],
//                'pluginOptions' => [
////                    'tags' => $searchModel->roles,
//                    'value' => $searchModel->roles,
//                    'allowClear' => true,
//                    'minimumInputLength' => 2,
//                    'ajax' => [
//                        'url' => \yii\helpers\Url::to('/category/category-list'),
//                        'dataType' => 'json',
//                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
//                    ],
//                ]
//            ]),
            'format' => 'html'
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            "label" => Yii::t("app/user", "created at"),
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
            "label" => Yii::t("app/user", "updated at"),
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
            'template' => '{view}{update}'
        ]
    ]
]); ?>

<?php echo \yii\helpers\Html::a(Yii::t("app/user", 'Create a new user'), '/user/create', ['class' => 'btn btn-primary']); ?>


