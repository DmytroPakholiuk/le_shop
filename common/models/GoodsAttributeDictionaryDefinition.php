<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property-read Attribute $attributeDefinition
 */
class GoodsAttributeDictionaryDefinition extends ActiveRecord
{
    public static function getDefinitionsFor(Attribute $attribute, bool $asArray = false): array
    {
        $query = self::find()->where(['attribute_id' => $attribute->id]);
        if ($asArray){
            $query->asArray()->indexBy('id');
        }
        return $query->all();
    }

    public static function tableName()
    {
        return 'attributes_dictionary_definitions';
    }

    public function rules()
    {
        return [
            [['attribute_id'], 'integer'],
            [['value'], 'string'],
            [['attribute_id', 'value'], 'required']
        ];
    }

    public function getAttributeDefinition()
    {
        return $this->hasOne(Attribute::class, ['id' => 'attribute_id']);
    }
}