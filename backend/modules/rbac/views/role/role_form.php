<?php

/**
 * @var \backend\modules\rbac\models\Item $model
 * @var \yii\web\View $this
 * @var \backend\modules\rbac\models\Item[] $permissions
 * @var \yii\web\User $user
 * @var array $childPermissions
 * @var array $fullPermissions
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/rbac_role_form.js', ['depends' => \backend\assets\AppAsset::class]);
$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['disabled' => !$model->isNewRecord])->label(Yii::t("app/rbac", "name")) ?>

<?= $form->field($model, 'description')->textarea()->label(Yii::t("app/rbac", "description")); ?>

    <h3><?= Yii::t("app/rbac", "Permissions") ?></h3>

<div class="card">
    <div class="card-body">
        <?= Yii::t("app/rbac", "Info: You only have to check direct children. Red color shows the rule applied to permission.
        Blue means the permission is available as a deep child.") ?>
    </div>
</div>

<?= Yii::t("app/rbac", "Search for permissions") ?>:
<?= Html::input('text', null, null, [
        'id' => 'permissionSearch',
        'class' => 'form-control',
        'onfocusout' => 'search()'
]) ?>
<br/>

<?php
$cols = 3;
$itemCount = count($permissions);
$i = 1;
echo "<div class='row'>";
echo "<div class='col'>";
foreach ($permissions as $permission){
    echo '<div class="permission-item">';
    echo Html::checkbox("Permissions[{$permission->name}]",
        isset($childPermissions[$permission->name]),
        [
            'id' => "Permissions[{$permission->name}]",
            'onchange' => "repaintSelection('{$permission->name}')"
//            'class' => 'form-control',
        ]);
//    $labelStyle = isset($fullPermissions[$permission->name]) ? 'color: blue;' : '';
    $labelText = "{$permission->name} " . (!empty($permission->rule_name) ? "<div style='color: red'> :{$permission->rule_name}</div>" : "");
    echo Html::label($labelText, "Permissions[{$permission->name}]", [
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

<?= Html::submitButton(Yii::t("app", "submit"), ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>
