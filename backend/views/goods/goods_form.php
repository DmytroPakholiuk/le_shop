<?php

/**
 * @var \common\models\Goods $model
 * @var array $categories
 * @var \yii\web\View $this
 * @var bool $isNew
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name'); ?>

<?= $form->field($model, 'description')->textarea(); ?>

<?= $form->field($model, 'price'); ?>

<?= $form->field($model, 'available')->dropDownList([0 => 'No', 1 => 'Yes'], ['options' => [1 => ['selected' => true]]]); ?>

<?= $form->field($model, 'category_id')
    ->dropDownList($categories, ['prompt' => 'Category'])
    ->label('Select category'); ?>

<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Add images') ?>

<?php if (!$isNew) {
    echo Html::checkbox('deleteOld', false, ['label' => 'delete all old images?']);
} ?><br>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end();?>