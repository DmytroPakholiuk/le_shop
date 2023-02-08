<?php
/**
 * @var \common\models\Category $category
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
            'value' => $category->parent->name ?? 'not set',
        ],
        'created_at:datetime',
        'updated_at:datetime'
    ]
]); ?>


<br>
<a href="update">update</a><br>
<a href="delete">delete</a>