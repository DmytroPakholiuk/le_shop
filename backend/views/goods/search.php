<?php

use common\models\GoodsAttributeDictionaryDefinition;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $attributeDefinitions \common\models\Attribute[] */

?>

    <div class="post-search">

    <h4> Search by Attributes: </h4>
    <?php
        foreach ($attributeDefinitions as $attributeDefinition){
            switch ($attributeDefinition->type){
                case 'text':
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->label($attributeDefinition->name);
                    break;
                case ($attributeDefinition->type == 'integer' || $attributeDefinition->type == 'float'):
                    echo "<label>{$attributeDefinition->name}</label>";
                    echo '<div class="row">';
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}][from]", [
                            'options' => [
                                'class' => 'col'
                            ]
                        ])->input('text', ['placeholder' => 'from'])->label(false);
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}][to]", [
                            'options' => [
                                'class' => 'col'
                            ]
                        ])->input('text', ['placeholder' => 'to'])->label(false);
                    echo "</div>";
                    break;
                case 'boolean':
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->dropDownList([0 => 'No', 1 => 'Yes', 100 => '[any]'])->label($attributeDefinition->name);
                    break;
                case 'dictionary':
                    $dictionary = GoodsAttributeDictionaryDefinition::getDefinitionsFor($attributeDefinition, true);
                    $options = [];
                    foreach ($dictionary as $key => $item){
                        $options[$key] = $item['value'];
                    }
                    $options[100] = '[any]';
                    echo $form->field($model->attributeValueSearch, "searchValues[{$attributeDefinition->id}]")
                        ->dropDownList($options)->label($attributeDefinition->name);
            }
        }
    ?>

        <div class="form-group">
            <?= Html::submitButton('Find', ['class' => 'btn btn-info']) ?>
            <?= Html::a('Clear', Url::to('/goods/index'), ['class' => 'btn btn-default']) ?>
        </div>


</div>
