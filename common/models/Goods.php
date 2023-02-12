<?php

namespace common\models;
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property int $available
 * @property int $category_id
 * @property-read Category $category
 * @property int $author_id
 * @property-read User $author
 * @property int $target_credit_card
 * @property string $created_at
 * @property string $updated_at
 * @property-read array $goodsAttributes
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'goods';
    }
    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['id', 'available', 'category_id', 'author_id', 'target_credit_card'], 'integer'],
            [['name', 'description'], 'string'],
            ['price', 'double'],
            ['target_credit_card', 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    /*
    public function getGoodsAttributes()
    {
        return $this->hasMany(Attribute::class, ['id' => 'goods_id'])->viaTable('goodsAttributes', ['attribute_id' => 'id']);
    }
    */
}
