<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\User $model
 * @var \yii\rbac\DbManager $auth
 * @var array $roles
 * @var array $userRoles
 */

use yii\helpers\Html;


?>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?= $form->field($model, 'username'); ?>

<?= $form->field($model, 'email'); ?>

<?= $form->field($model, 'status')->dropDownList(\common\models\User::statuses()); ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<h3>Assign Roles</h3>

<?php
$cols = 3;
$itemCount = count($roles);
$i = 1;
echo "<div class='row'>";
echo "<div class='col'>";
foreach ($roles as $role){
    echo '<div class="permission-item">';
    echo Html::checkbox("Roles[{$role->name}]",
        isset($userRoles[$role->name]),
        [
            'id' => "Roles[{$role->name}]",
//            'onchange' => "repaintSelection('{$role->name}')"
//            'class' => 'form-control',
        ]);
    $labelText = "{$role->name}";
    echo Html::label($labelText, "Roles[{$role->name}]", [
        'style' => 'margin-left: 7px;'// . $labelStyle,
//            'class' => 'form-control',
    ]);
    echo '</div>';
//    echo '<br>';


    if ($i++ >= ceil($itemCount / 3)){
        $i = 1;
        echo '</div>';
        echo "<div class='col'>";
    }
}

echo "</div>";
echo "</div>";
?>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php \yii\widgets\ActiveForm::end(); ?>

