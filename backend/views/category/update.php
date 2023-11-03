<?php
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Category $category
 * @var array $categories
 * @var yii\web\View $this
 */

$this->title = Yii::t("app/category", 'Update existing category')?>

<h1><?= Yii::t("app/category", 'Update existing category') ?></h1><br>

<?= $this->render('category_form', ['category' => $category, 'categories' => $categories]); ?>