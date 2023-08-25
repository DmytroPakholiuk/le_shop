<?php

namespace backend\modules\rbac\models;

use yii\rbac\DbManager;

/**
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property $data
 * @property int $created_at
 * @property int $updated_at
 */
class Item extends \yii\db\ActiveRecord
{
    public DbManager $auth;
    public const TYPE_ROLE = 1;
    public const TYPE_PERMISSION = 2;

    public function init()
    {
        parent::init();
        $this->auth = \Yii::$app->authManager;
    }

    public static function tableName()
    {
        return 'auth_item';
    }

    public static function primaryKey()
    {
        return ['name'];
    }

    public function rules()
    {
        return [
            [['name', 'rule_name'], 'string', 'length' => [0, 63]],
            [['type'], 'in', 'range' => [1,2]],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'description'], 'required']
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(self::class, ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    public function getParents()
    {
        return $this->hasMany(self::class, ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }
}