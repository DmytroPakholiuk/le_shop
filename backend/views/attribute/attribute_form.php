<?php

/**
 * @var \common\models\Attribute $model
 * @var \yii\web\View $this
 * @var string[] $types
 * @var \common\models\GoodsAttributeDictionaryDefinition[]|null $definitions
 */

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/attribute_form.js');

$form = ActiveForm::begin(['id' => 'category_create_form']);?>

<?= $form->field($model, 'name')->textInput()->label(Yii::t("app/attribute", "name")) ?>

<?= $form->field($model, 'category_id')->widget(Select2::class, [
    'model' => $model,
    "language" => "uk-UK",
//    'data' => $categories,
    'options' => [
        'placeholder' => Yii::t("app/category", 'Start entering category'),
        'id' => 'category-select'
    ],
//    'data' => $dataList
    'pluginOptions' => [
        'minimumInputLength' => 2,
        'ajax' => [
            'url' => \yii\helpers\Url::to('/category/category-list'),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
    ]
])->label(Yii::t("app/attribute", "category")) ?>

<?= $form->field($model, 'type')->dropDownList($types, [
        'id' => 'type-select',
        'onchange' => 'selectType()',
        'options' => [array_search($model->type, $types) => ['Selected' => true]]
])->label(Yii::t("app/attribute", "type")) ?>

<div id="definition-form" hidden="hidden">
    <?= Html::button(Yii::t("app/attribute", 'Add dictionary definition'),
        [
            'onclick' => 'generateDefinitionHtml()',
            'class' => 'btn btn-primary'
        ]) ?>

    <?php if (!empty($definitions)) {
        //populate with already existing definitions
        $definitionCount = 100;
        foreach ($definitions as $definition){
            $definitionCount ++ ?>
            <div class="row" id="definition-<?= $definitionCount ?>">
                <?php echo Html::input('text',
                    'Attribute[dictionaryDefinition][' . $definitionCount . ']',
                    $definition->value,
                    [
                        'class' => 'form-control col-6',
                        'style' => 'margin: 10px'
                    ]
                ); ?>
                <?php echo Html::button(Yii::t("app/attribute", 'Delete definition'), [
                    'class' => 'btn btn-danger col-1',
                    'style' => 'margin: 10px',
                    'onclick' => "eraseElement('definition-$definitionCount')"
                ]) ?>
            </div>
    <?php  }
    } ?>
</div>

<br>

<?= Html::submitButton(Yii::t("app", 'submit'), ['class' => 'btn btn-primary']);?>

<?php ActiveForm::end();?>
