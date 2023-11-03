<?php

/**
 * @var \common\models\Goods $model
// * @var array $categories
 * @var \yii\web\View $this
 */

use kartik\file\FileInput;
use kartik\icons\FontAwesomeAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerJs('let goodsId = ' . ($model?->id ?? '0') . ';', \yii\web\View::POS_HEAD);
//var_dump($model?->id);die();
$this->registerJsFile('/js/goods_form.js', ['depends' => \backend\assets\AppAsset::class]);
FontAwesomeAsset::register($this);

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->label(Yii::t("app/goods", "name")); ?>

<?= $form->field($model, 'description')->textarea()->label(Yii::t("app/goods", "description")); ?>

<?= $form->field($model, 'price')->label(Yii::t("app/goods", "price")); ?>

<?= $form->field($model, 'available')
    ->dropDownList([0 => Yii::t("app", 'no'), 1 => Yii::t("app", 'yes')], ['options' => [1 => ['selected' => true]]])
    ->label(Yii::t("app/goods", "available")); ?>

<?php //echo $form->field($model, 'category_id')
//    ->dropDownList($categories, ['prompt' => 'Category'])
//    ->label('Select category'); ?>
<?= $form->field($model, 'category_id')->widget(Select2::class, [
    'model' => $model,
    'options' => [
        'placeholder' => 'Start entering category:',
        'onchange' => 'renderAttributeForm()',
        'id' => 'categoryPicker'

    ],
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/category/category-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
])->label(Yii::t("app/goods", "category")) ?>

<?= $form->field($model, 'author_id')->widget(Select2::class, [
    'model' => $model,
    'options' => [
        'placeholder' => 'Start entering user:',
        'onchange' => 'renderAttributeForm()',
        'id' => 'authorPicker'

    ],
    'pluginOptions' => [
        'minimumInputLength' => 3,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/frontend-user/user-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
])->label(Yii::t("app/goods", "author")) ?>

<?php //echo Html::button('Add Attribute', ['class' => 'btn btn-primary', 'onclick' => 'addAttribute()']); ?>



<div id="attributeForm">

</div>

<?php if (!$model->isNewRecord) {
//    echo Html::checkbox('deleteOldAttributes', false, ['label' => 'delete all old attributes?']);
} ?><br>

<?php //echo $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Add images') ?>

<?php
$initialPreview = [];
$initialPreviewConfig = [];
foreach ($model->images as $image){
    $initialPreview[] = Url::to('/'.$image->path);
    $initialPreviewConfig[] = ['key' => $image->id];
}
if (!$model->isNewRecord){
    Pjax::begin();

    if (!empty($model->images)) {
        echo $form->field($model, 'images[]')->label('Delete existing images')->widget(FileInput::class,[
//    echo FileInput::widget([
//            'name' => 'Delete old images',
            'options'=>[
                'multiple'=>true
            ],
            'pluginOptions' => [
                'initialPreview' => $initialPreview,
                'initialPreviewAsData'=>true,
                'overwriteInitial'=>false,
                'maxFileSize'=>2800,
                'deleteUrl' => Url::to('/goods/delete-image'),
                'initialPreviewConfig' => $initialPreviewConfig,
                'uploadUrl' => Url::to(['/goods/upload-image']),
//            'uploadExtraData' => [
//                'goods_id' => $model->id
//            ],
                'fileActionSettings' => [
                    'showDelete' => false,
                    'showUpload' => false,
                ],
                'showUpload' => false
            ]
        ]);
    }

    echo $form->field($model, 'imageFiles[]')->label('Add images to the goods')->widget(FileInput::class,[
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'overwriteInitial'=>false,
            'maxFileSize'=>2800,
            'uploadExtraData' => [
                'goods_id' => $model->id
            ],
        ]
    ]);
//    echo Html::submitButton('Upload images', ['/goods/update', 'id' => $model->id]);
//    echo Html::a('upload images', Url::to('/goods/upload-image', []), ['class' => 'btn btn-primary']);

    Pjax::end();

} else {
    echo $form->field($model, 'imageFiles[]')->label('Add images to the goods')->widget(FileInput::class,[
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'overwriteInitial'=>false,
            'maxFileSize'=>2800,
            'uploadExtraData' => [
                'goods_id' => $model->id
            ],
        ]
    ]);
}

?>

<?php if (!$model->isNewRecord) {
    echo Html::checkbox('deleteOldImages', false, ['label' => 'delete all old images?']);
} ?><br>

<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'submitButton']); ?>

<?php ActiveForm::end();?>