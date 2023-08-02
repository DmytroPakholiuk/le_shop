<?php

/**
 * @var \common\models\Order $model
// * @var array $categories
 * @var \yii\web\View $this
 */

use yii\widgets\DetailView;

$this->title = "Order no. {$model->id}" ?>

<?php echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id:integer',
        [
            'label' => 'Ordered',
            'value' => $model->goods[0]->name
        ],
        'sum_price',
        [
            'label' => 'Customer',
            'value' => $model->customer->username ?? null
        ],
        'delivery_address',
        'created_at:datetime',
        'updated_at:datetime',
    ]
]); ?>