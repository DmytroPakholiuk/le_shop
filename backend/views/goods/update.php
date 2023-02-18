<?php

/**
 * @var \common\models\Goods $model
 * @var array $categories
 * @var \yii\web\View $this
 */

$this->title = 'Update existing item'; ?>

<h1>Update existing item</h1>

<?php echo $this->render('goods_form', ['model' => $model, 'categories' => $categories]); ?>
