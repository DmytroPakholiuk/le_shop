<?php

namespace common\models;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property int $created_at
 * @property int $updated_at
 */
class FrontendUser extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return "frontend_users";
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name', 'password'], 'string'],
            [['email_verified_at', 'created_at', 'updated_at'], 'safe'],
            [['email'], 'email']
        ];
    }
}