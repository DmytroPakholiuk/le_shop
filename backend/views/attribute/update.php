<?php


/**
 * @var \common\models\Attribute $model
 * @var yii\web\View $this
 * @var string[] $types
 * @var array|null $definitions
 */

$this->title = 'Update existing attribute'; ?>

    <h1>Update existing attribute</h1><br>

<?php echo $this->render('attribute_form', ['model' => $model, 'types' => $types, 'definitions' => $definitions]);