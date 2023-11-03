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

$this->title = Yii::t("app/order", "Create a new order");

$form = ActiveForm::begin(); ?>

<?php echo $form->field($orderGoods, 'goods_id')->widget(Select2::class, [
    'model' => $orderGoods,
    'options' => [
        'placeholder' => Yii::t("app/goods", 'Start entering goods'),

    ],
    "language" => "uk-UK",
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/goods/goods-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
])->label(Yii::t("app/order", "goods id"))  ?>

<?php echo $form->field($order, 'payment_method')
    ->dropDownList([0 => 'Cash upon receiving', 1 => 'Card beforehand'], ['options' => [1 => ['selected' => true]]])
    ->label(Yii::t("app/order", "payment method")); ?>

<?php echo $form->field($order, 'delivery_method')
    ->dropDownList([0 => 'delivery1', 1 => 'delivery2'], ['options' => [0 => ['selected' => true]]])
    ->label(Yii::t("app/order", "delivery method")); ?>

<?php echo $form->field($order, 'status')
    ->dropDownList([0 => 'Active', 1 => 'Inactive'], ['options' => [0 => ['selected' => true]]])
    ->label(Yii::t("app/order", "status")); ?>

<?php echo $form->field($order, "delivery_address")->label(Yii::t("app/order", "delivery address")); ?>

<?php echo Html::submitButton(Yii::t("app", 'submit'), ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>




