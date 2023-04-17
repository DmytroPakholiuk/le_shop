<?php

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="post-search">

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>

<?= $form->field($model, 'name'); ?>

<?= $form->field($model, 'description')->textarea(); ?>

<?= $form->field($model, 'price_from'); ?>

<?= $form->field($model, 'price_to'); ?>

<?= $form->field($model, 'available')->dropDownList([0 => 'No', 1 => 'Yes'], ['options' => [1 => ['selected' => true]]]); ?>

<?= $form->field($model, 'category_id')->widget(Select2::class, [
    'model' => $model,
    'options' => [
        'placeholder' => 'Start entering category:',

    ],
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'allowClear' => true,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/category/category-list'),
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
