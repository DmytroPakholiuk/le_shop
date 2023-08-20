<?php
/**
 * @var \common\models\Attribute $model
 * @var \yii\web\View $this
 * @var \common\models\GoodsAttributeDictionaryDefinition[] $definitions
 * @var \common\models\Category $category
 * @var array $types
 */

use yii\widgets\DetailView;

$this->title = "Attribute '{$model->name}' of category '{$category->name}'"; ?>

<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id:integer',
        'name',
        [
                'attribute' => 'type',
            'value' => $types[$model->type]
        ],
        'price',
        [
            'label' => 'Category',
            'value' => $category->name ?? "[All Categories]"
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ]
]); ?>

<br>

<?php

if (!empty($definitions)){
    $config = [
        'model' => $model,
        'attributes' => []
    ];

    foreach ($definitions as $definition){
        $config['attributes'][] = [
            'label' => 'definition (# ' . $definition->id . ')',
            'format' => 'raw',
            'value' => $definition->value
        ];
    }

    echo DetailView::widget($config);
}


