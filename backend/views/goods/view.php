<?php
/**
 * @var \common\models\Goods $model
 */

use yii\widgets\DetailView;

?>

<?php $this->title = $model->name ?>

<?php echo DetailView::widget([
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
            'updated_at:datetime',
        ]
]); ?>

<h2>Attributes:</h2>

<?php
    $config = [
        'model' => $model,
        'attributes' => []
    ];
    foreach ($model->attributeValues as $attribute){
        $config['attributes'][] = [
            'label' => $attribute->attributeDefinition->name,
            'value' => $attribute->value
        ];
    }
    echo DetailView::widget($config) ?>

<?php
foreach($model->images as $image){
    echo '<div>';
    echo "<img src=\"/{$image->path}\">";
    echo '</div>';
}

