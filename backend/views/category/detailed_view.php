<?php
/**
 * @var \common\models\Category $category
 * @var \common\models\Category $parent_category
 * @var yii\web\View $this
 */

$this->title = 'Category #'.$category->id;?>

<?php echo \yii\widgets\DetailView::widget([
    'model' => $category,
    'attributes' => [
        'name',
        'id',
        'description:html',
        [
            'label' => 'Parent category',
            'value' => isset($parent_category)? $parent_category->name: null,
        ],
        'created_at:datetime',
        'updated_at:datetime'
    ]
]); ?>


<br>
<a href="update">update</a><br>
<a href="delete">delete</a>