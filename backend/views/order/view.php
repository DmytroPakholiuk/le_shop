<?php

/**
 * @var \common\models\Order $model
// * @var array $categories
 * @var \yii\web\View $this
 */

use yii\widgets\DetailView;

$this->title = Yii::t("app/order", "Order no.{num}", [
    "num" => $model->id
]) ?>

<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id:integer',
        [
            'label' => Yii::t("app/order", "goods"),
            'value' => $model->goods[0]->name
        ],
        [
            "label" => Yii::t("app/order", "sum price"),
            "attribute" => "sum_price"
        ],
        [
            'label' => Yii::t("app/order", "customer"),
            'value' => $model->customer->username ?? null
        ],
        [
            "attribute" => "delivery_address",
            'label' => Yii::t("app/order", "delivery address"),
        ],
        [
            'value' => $model->created_at,
            'label' => Yii::t("app/order", 'created at'),
            'format' => 'datetime'
        ],
        [
            'value' => $model->updated_at,
            'label' => Yii::t("app/order", 'updated at'),
            'format' => 'datetime'
        ],
    ]
]); ?>