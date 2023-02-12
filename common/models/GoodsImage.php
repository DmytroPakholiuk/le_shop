<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $path
 * @property int $size
 * @property int $height
 * @property int $width
 * @property int $goods_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read Goods $goods
 */
class GoodsImage extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'goods_images';
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['size', 'height', 'width', 'goods_id'], 'integer'],
            [['path'], 'string'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods(){
        return $this->hasOne(Goods::class, ['id' => 'goods_id']);
    }
}