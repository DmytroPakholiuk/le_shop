<?php
/**
 * @var \common\models\Goods $model
 */

use yii\widgets\DetailView;

$this->registerJsFile('/js/goods_view.js');
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
        if (!$attribute->is_deleted){
            $config['attributes'][] = [
                'label' => $attribute->attributeDefinition->name,
                'format' => 'raw',
                'value' => $attribute->value . \yii\helpers\Html::button('del', [
                        'class' => 'btn btn-danger',
                        'id' => $attribute->attribute_id,
                        'onclick' => "deleteAttribute({$model->id}, {$attribute->attribute_id})"
                    ])
            ];
        }
    }
    echo DetailView::widget($config) ?>

<?php
foreach($model->images as $image){
    echo '<div>';
    echo "<img src=\"/{$image->path}\">";
    echo '</div>';
}

