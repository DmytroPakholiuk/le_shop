<?php

/**
 * @var \common\models\Goods $model
 * @var array $categories
 * @var \yii\web\View $this
 */

use kartik\file\FileInput;
use kartik\icons\FontAwesomeAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/goods_form.js');
FontAwesomeAsset::register($this);

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name'); ?>

<?= $form->field($model, 'description')->textarea(); ?>

<?= $form->field($model, 'price'); ?>

<?= $form->field($model, 'available')->dropDownList([0 => 'No', 1 => 'Yes'], ['options' => [1 => ['selected' => true]]]); ?>

<?php //echo $form->field($model, 'category_id')
//    ->dropDownList($categories, ['prompt' => 'Category'])
//    ->label('Select category'); ?>
<?= $form->field($model, 'category_id')->widget(Select2::class, [
    'model' => $model,
    'options' => [
        'placeholder' => 'Start entering category:',

    ],
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/category/category-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
]) ?>

<?php echo Html::button('Add Attribute', ['class' => 'btn btn-primary', 'onclick' => 'addAttribute()']); ?>

<div id="attributeForm">
    <p>Any existing attributes with the same name will be overwritten</p>

</div>

<?php if (!$model->isNewRecord) {
    echo Html::checkbox('deleteOldAttributes', false, ['label' => 'delete all old attributes?']);
} ?><br>

<?php //echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Add images') ?>

<?php
$initialPreview = [];
foreach ($model->images as $image){
    $initialPreview[] = Url::to('/'.$image->path);
}
echo $form->field($model, 'imageFiles[]')->label('Add images')->widget(FileInput::class,[
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'initialPreview' => $initialPreview,
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>false,
            'maxFileSize'=>2800
    ]
]) ?>

<?php if (!$model->isNewRecord) {
    echo Html::checkbox('deleteOldImages', false, ['label' => 'delete all old images?']);
} ?><br>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end();?>