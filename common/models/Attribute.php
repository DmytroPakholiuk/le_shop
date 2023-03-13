<?php

namespace common\models;
/**
 * @property string $name
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'string'],
            [['created_at','updated_at'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(GoodsAttributeValue::class, ['attribute_id' => 'id']);
    }
}