<?php

use common\models\GoodsAttributeDictionaryDefinition;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use common\models\Attribute;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $attributeDefinitions \common\models\Attribute[] */

?>

    <div class="post-search">

    <h4> <?= Yii::t("app/goods", "Search by Attributes") ?>: </h4>
    <?php
        foreach ($attributeDefinitions as $attributeDefinition){
            switch ($attributeDefinition->type){
                case Attribute::ATTRIBUTE_TYPE_TEXT:
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->label($attributeDefinition->name);
                    break;
                case ($attributeDefinition->type == Attribute::ATTRIBUTE_TYPE_INTEGER || $attributeDefinition->type == Attribute::ATTRIBUTE_TYPE_FLOAT):
                    echo "<label>{$attributeDefinition->name}</label>";
                    echo '<div class="row">';
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}][from]", [
                            'options' => [
                                'class' => 'col'
                            ]
                        ])->input('text', ['placeholder' => Yii::t("app", 'from')])->label(false);
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}][to]", [
                            'options' => [
                                'class' => 'col'
                            ]
                        ])->input('text', ['placeholder' => Yii::t("app", 'to')])->label(false);
                    echo "</div>";
                    break;
                case Attribute::ATTRIBUTE_TYPE_BOOLEAN:
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->dropDownList([
                            '' => '',
                            0 => Yii::t("app", 'no'),
                            1 => Yii::t("app", 'yes')
                        ])->label($attributeDefinition->name);
                    break;
                case Attribute::ATTRIBUTE_TYPE_DICTIONARY:
                    $dictionary = GoodsAttributeDictionaryDefinition::getDefinitionsFor($attributeDefinition, true);
                    $options = [];
                    foreach ($dictionary as $key => $item){
                        $options[$key] = $item['value'];
                    }
                    $options = array_merge(['' => ''], $options);
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->dropDownList($options)->label($attributeDefinition->name);
            }
        }
    ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t("app", 'find'), ['class' => 'btn btn-info']) ?>
            <?= Html::a(Yii::t("app", 'clear'), Url::to('/goods/index'), ['class' => 'btn btn-default']) ?>
        </div>


</div>
