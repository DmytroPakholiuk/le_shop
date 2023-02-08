<?php

/**
 * @var \common\models\Category $category
 * @var yii\web\View $this
 */

$this->title = 'Category #'.$category->id;?>

<h1><?php echo $category->name ?></h1><br>

<ul>
    <li><?php echo $category->description; ?></li>
    <li>Category ID: <?php echo $category->id; ?></li>
    <li>Created at: <?php echo $category->created_at; ?></li>
    <li>Updated at: <?php echo $category->updated_at; ?></li>

    <?php if(isset($parent_category)){
        echo "<li>Parent category: ".$category->parent->name ?? 'not set'." </li>";
        } ?>

</ul>


<br>
<a href="update">update</a><br>
<a href="delete">delete</a>

