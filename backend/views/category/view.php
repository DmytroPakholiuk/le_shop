<?php

/**
 * @var \common\models\Category $category
 *
 * @var yii\web\View $this
 */

$this->title = 'Category #'.$category->id;?>

<h1><?php echo $category->name ?></h1><br>

<?php echo $category->description; ?><br>
Category ID: <?php echo $category->id; ?><br>
Created at: <?php echo $category->created_at; ?><br>
Updated at: <?php echo $category->updated_at; ?><br>
<br>
<a href="update">update</a><br>
<a href="delete">delete</a>