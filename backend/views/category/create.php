<?php
use common\models\Category;

/**
 * @var Category $category - new Category
 * @var array $categories
 * @var yii\web\View $this
 */

$this->title = Yii::t("app/category", 'Create a new category')?>

<h1><?= Yii::t("app/category", 'Create a new category') ?></h1><br>

<?= $this->render('category_form', ['category' => $category, 'categories' => $categories]); ?>
