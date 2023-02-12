<?php

/**
 * @var \common\models\Goods $model
 * @var array $categories
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create a new item'; ?>

<h1>Create a new item</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name'); ?>

<?= $form->field($model, 'description')->textarea(); ?>

<?= $form->field($model, 'price'); ?>

<?= $form->field($model, 'available')->dropDownList([0 => 'No', 1 => 'Yes']); ?>

<?= $form->field($model, 'category_id')->dropDownList($categories); ?>

<?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end();?>
