<?php

/**
 * @var \common\models\Goods $model
 * @var array $categories
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update existing item'; ?>

<h1>Update existing item</h1>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'name'); ?>

<?php echo $form->field($model, 'description')->textarea(); ?>

<?php echo $form->field($model, 'price'); ?>

<?php echo $form->field($model, 'available')->dropDownList([0 => 'No', 1 => 'Yes']); ?>

<?php echo $form->field($model, 'category_id')->dropDownList($categories); ?>

<?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end();?><?php
