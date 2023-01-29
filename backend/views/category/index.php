<?php

/**
 * @var $model - Array of Category objects
 *
 * @var yii\web\View $this
 */

$this->title = 'Category List';?>

<h1>Category List</h1>

<?php foreach ($model as $category){
    ?>

    <a href="view?id=<?php echo $category->id ?>"> <?php echo $category->name ?></a> <br>
    <?php echo $category->description ?> <br>
    <br>


<?php }