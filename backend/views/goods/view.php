<?php
/**
 * @var \common\models\Goods $model
 * @var \yii\web\View $this
 * @var array $attributes
 */

use yii\widgets\DetailView;

$this->registerJsFile('/js/goods_view.js');
?>

<?php $this->title = $model->name ?>

<?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:integer',
            [
                'label' => Yii::t("app/goods", 'name'),
                'value' => $model->name
            ],
            [
                'label' => Yii::t("app/goods", 'description'),
                'value' => $model->description
            ],
            [
                'label' => Yii::t("app/goods", 'is available'),
                'value' => $model->available
            ],
            [
                'value' => $model->price,
                'label' => Yii::t("app/goods", 'price'),
//                'format' => 'double'
            ],
            [
                'label' => Yii::t("app/goods", 'category'),
                'value' => $model->category->name ?? null
            ],
            [
                'label' => Yii::t("app/goods", 'author'),
                'value' => $model->author->username ?? null
            ],
            'target_credit_card',
            [
                'value' => $model->created_at,
                'label' => Yii::t("app/goods", 'created at'),
                'format' => 'datetime'
            ],
            [
                'value' => $model->updated_at,
                'label' => Yii::t("app/goods", 'updated at'),
                'format' => 'datetime'
            ],
        ]
]); ?>

<h2>Attributes:</h2>

<?php
    $config = [
        'model' => $model,
        'attributes' => []
    ];
    foreach ($attributes as $attribute){
        /**
         * @var \common\models\Attribute $attributeDefinition
         */
        $attributeDefinition = $attribute['definition'];
        /**
         * @var \common\models\GoodsAttributeValue $attributeValue
         */
        $attributeValue = $attribute['value'];
        if ($attributeValue !== null){
            $config['attributes'][] = [
                'label' => $attributeDefinition->name,
                'format' => 'raw',
                'value' => $attributeValue->getPresentableValue()
            ];
        }
    }
//    foreach ($model->attributeValues as $attribute){
//        if (!$attribute->is_deleted){
//            $config['attributes'][] = [
//                'label' => $attribute->attributeDefinition->name,
//                'format' => 'raw',
//                'value' => $attribute->value . \yii\helpers\Html::button('del', [
//                        'class' => 'btn btn-danger',
//                        'id' => $attribute->attribute_id,
//                        'onclick' => "deleteAttribute({$model->id}, {$attribute->attribute_id})"
//                    ])
//            ];
//        }
//    }
    echo DetailView::widget($config) ?>

<?php
foreach($model->images as $image){
    echo '<div>';
    echo "<img src=\"/{$image->path}\">";
    echo '</div>';
}

