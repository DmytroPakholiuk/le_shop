<?php

namespace common\models;

class Category extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            [['name', 'description'], 'string',],
            [['name'], 'required',],
            //[['name'], 'max' => 127],
            //[['description'], 'max' => 9000],
        ];
    }

    public static function tableName()
    {
        return 'categories';
    }



}