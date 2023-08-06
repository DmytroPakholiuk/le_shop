<?php

/**
 * @var \common\models\Attribute $model
 * @var \yii\web\View $this
 * @var string[] $types
 */

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/attribute_form.js');

$form = ActiveForm::begin(['id' => 'category_create_form']);?>

<?= $form->field($model, 'name')->textInput() ?>

<?= $form->field($model, 'category_id')->widget(Select2::class, [
    'model' => $model,
//    'data' => $categories,
    'options' => [
        'placeholder' => 'Start entering category:',
        'id' => 'category-select'
    ],
//    'data' => $dataList
    'pluginOptions' => [
        'minimumInputLength' => 2,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/category/category-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
]) ?>

<?= $form->field($model, 'type')->dropDownList($types, ['id' => 'type-select', 'onchange' => 'selectType()']) ?>

<div id="definition-form" hidden="hidden">
    <?= Html::button('add dictionary definition', ['onclick' => 'generateDefinitionHtml()', 'class' => 'btn btn-primary']) ?>
</div>

<br>

<?= Html::submitButton('submit', ['class' => 'btn btn-primary']);?>

<?php ActiveForm::end();?>
