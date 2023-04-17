<?php

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'status')->dropDownList([0 => 'inactive', 1 => 'active', ], ['prompt' => 'Select status'])?>

    <?= $form->field($model, 'parent_id')->widget(Select2::class, [
        'model' => $model,
//    'data' => $categories,
        'options' => [
            'placeholder' => 'Start entering category:',

        ],
//    'data' => $dataList
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'ajax' => [
                'url' => \yii\helpers\Url::to('category-list'),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
        ]
    ]) ?>


    <?php echo '<div class="drp-container">'; ?>

<!--    --><?php //= $form->field($model, 'created_between', [
////        'addon'=>['prepend'=>['content'=>'<i class="fas fa-calendar-alt"></i>']],
//        'options'=>['class'=>'drp-container mb-2']
//    ])->widget(DateRangePicker::classname(), [
//        'useWithAddon'=>true
//    ]); ?>
    <?php echo '<label> Created between </label>' ?>
    <?php echo DateRangePicker::widget([
            'model' => $model,
        'attribute'=>'created_between',
        'value'=>'2015-10-19 - 2015-11-03',
        'convertFormat'=>true,
//        'disabled' => true,
        'pluginOptions'=>[
            'locale'=>['format'=>'Y-m-d']
        ]
    ]); ?>

    <?php echo '</div>'; ?>

    <div class="form-group">
        <?= Html::submitButton('Find', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Clear', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>