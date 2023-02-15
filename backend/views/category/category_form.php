<?php

use common\models\Category;
use yii\helpers\Html;
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

<?= $form->field($category, 'parent_id')->dropDownList($categories, ['prompt' => 'Select parent category'])->label('Parent category'); ?>

<?= Html::submitButton('submit', ['class' => 'btn btn-primary']);?>

<?php ActiveForm::end();?>