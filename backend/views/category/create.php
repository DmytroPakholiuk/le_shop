<?php
use common\models\Category;

/**
 * @var Category $category - new Category
 * @var array $categories
 * @var yii\web\View $this
 */

$this->title = 'Create a new category'?>

<h1>Create a new category</h1><br>

<?= $this->render('category_form', ['category' => $category, 'categories' => $categories]); ?>
