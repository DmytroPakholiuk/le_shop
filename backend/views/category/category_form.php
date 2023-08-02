<?php

use common\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/**
 * @var Category $category - new Category
 * @var array $categories
 * @var yii\web\View $this
 */

$form = ActiveForm::begin(['id' => 'category_create_form']);?>

<?= $form->field($category, 'name')->textInput() ;?>

<?= $form->field($category, 'description')->textarea();?>

<?= $form->field($category, 'status')->dropDownList([0 => 'inactive', 1 => 'active', ], ['prompt' => 'Select status'])?>

<?php /*= $form->field($category, 'parent_id')->dropDownList($categories, ['prompt' => 'Select parent category'])->label('Parent category'); */?>

<?= $form->field($category, 'parent_id')->widget(Select2::class, [
    'model' => $category,
//    'data' => $categories,
    'options' => [
        'placeholder' => 'Start entering category:',

        ],
//    'data' => $dataList
    'pluginOptions' => [
        'minimumInputLength' => 2,
            'ajax' => [
            'url' => \yii\helpers\Url::to('category-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
]) ?>



<?= Html::submitButton('submit', ['class' => 'btn btn-primary']);?>

<?php ActiveForm::end();?>