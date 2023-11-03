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

$this->title = Yii::t("app/rbac", 'Update existing permission'); ?>

<?php $form = ActiveForm::begin(); ?>


<?= $form->field($model, 'name')->textInput(['disabled' => true])->label(Yii::t("app/rbac", "name")) ?>

<?= $form->field($model, 'description')->textarea()->label(Yii::t("app/rbac", "description")); ?>

<?= $form->field($model, 'rule_name')->textInput(['disabled' => true])->label(Yii::t("app/rbac", "rule name")) ?>

<?= \yii\helpers\Html::submitButton(Yii::t("app", 'submit'), ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>

