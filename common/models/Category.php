<?php

namespace common\models;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property int $parent_id
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string',],
            [['name'], 'required',],
            [['created_at','updated_at'], 'safe'],
            [['status', 'parent_id'], 'integer'],
        ];
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'categories';
    }
}