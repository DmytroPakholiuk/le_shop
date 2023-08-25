<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\rbac\models\Item $model
 * @var \backend\modules\rbac\models\Item[] $permissions
 * @var \yii\web\User $user
 * @var array $childPermissions
 * @var array $fullPermissions
 */

use yii\widgets\ActiveForm;

$this->title = 'Update existing role'; ?>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name')->textInput(['disabled' => true]) ?>

<?= $form->field($model, 'description')->textarea(); ?>

<?= $form->field($model, 'rule_name')->textInput(['disabled' => true]) ?>

<?= \yii\helpers\Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>

