<?php

/**
 * @var $model - Array of Category objects
 *
 *
 */


foreach ($model as $category){
    ?>

    <?php echo $category->name ?> <br>
    <?php echo $category->description ?> <br>
    <br>


<?php }