<?php

/**
 * @var $model - Array of Category objects
 *
 * @var yii\web\View $this
 */

$this->title = 'Category List';?>

<h1>Category List</h1>


<table class="table">
    <tr>
        <th> Name </th>
        <th> Description </th>
    </tr>

<?php foreach ($model as $category){
    ?>
    <tr>
        <td><a href="view?id=<?php echo $category->id ?>"> <?php echo $category->name ?></a> </td>
        <td><?php echo $category->description ?> </td>
    </tr>


<?php }?> </table>
