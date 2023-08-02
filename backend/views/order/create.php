<?php

/**
 * @var \common\models\Order $order
// * @var array $categories
 * @var \yii\web\View $this
 * @var \common\models\OrderGoods $orderGoods
 */

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(); ?>

<?php echo $form->field($orderGoods, 'goods_id')->widget(Select2::class, [
    'model' => $orderGoods,
    'options' => [
        'placeholder' => 'Start entering goods:',

    ],
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/goods/goods-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
])  ?>

<?php echo $form->field($order, 'payment_method')
    ->dropDownList([0 => 'Cash upon receiving', 1 => 'Card beforehand'], ['options' => [1 => ['selected' => true]]]); ?>

<?php echo $form->field($order, 'delivery_method')
    ->dropDownList([0 => 'delivery1', 1 => 'delivery2'], ['options' => [0 => ['selected' => true]]]); ?>

<?php echo $form->field($order, 'status')
    ->dropDownList([0 => 'Active', 1 => 'Inactive'], ['options' => [0 => ['selected' => true]]]); ?>

<?php echo $form->field($order, "delivery_address"); ?>

<?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>




