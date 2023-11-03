<?php

/**
 * @var \common\models\Attribute $model
 * @var yii\web\View $this
 * @var string[] $types
 * @var array|null $definitions
 */

$this->title = Yii::t("app/attribute", 'Create a new attribute'); ?>

<h1><?= Yii::t("app/attribute", 'Create a new attribute'); ?></h1><br>

<?php echo $this->render('attribute_form', ['model' => $model, 'types' => $types, 'definitions' => $definitions]);


