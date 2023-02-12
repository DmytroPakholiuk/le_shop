<?php
/**
 * @var \common\models\Goods $model
 */
?>

<?php $this->title = $model->name ?>

<?php echo \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:integer',
            'name',
            'description',
            [
                'label' => 'is Available',
                'value' => $model->available
            ],
            'price',
            [
                'label' => 'Category',
                'value' => $model->category->name ?? null
            ],
            [
                'label' => 'Author',
                'value' => $model->author->username ?? null
            ],
            'target_credit_card',
            'created_at:datetime',
            'updated_at:datetime'
        ]
]); ?>

<?php
foreach($model->images as $image){
    echo '<div>';
    echo "<img src=\"/{$image->path}\">";
    echo '</div>';
}

