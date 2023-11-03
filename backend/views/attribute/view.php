<?php
/**
 * @var \common\models\Attribute $model
 * @var \yii\web\View $this
 * @var \common\models\GoodsAttributeDictionaryDefinition[] $definitions
 * @var \common\models\Category $category
 * @var array $types
 */

use yii\widgets\DetailView;

$this->title = Yii::t("app/attribute", "Attribute '{name}' of category '{category}'", [
    "name" => $model->name,
    "category" => $model->category->name
]); ?>

<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id:integer',
        [
            "attribute" => 'name',
            "label" => Yii::t("app/attribute", 'name')
        ],
        [
                'attribute' => 'type',
            'value' => $types[$model->type],
            "label" => Yii::t("app/attribute", 'type')
        ],
        [
            "label" => Yii::t("app/attribute", 'category'),
            'value' => $category->name ?? "[All Categories]",
        ],
        [
            'value' => $model->created_at,
            'label' => Yii::t("app/attribute", 'created at'),
            'format' => 'datetime'
        ],
        [
            'value' => $model->updated_at,
            'label' => Yii::t("app/attribute", 'updated at'),
            'format' => 'datetime'
        ],
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


