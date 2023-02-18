<?php

namespace common\models;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

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
 * @property-read GoodsImage[] $images
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

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
            [['created_at', 'updated_at'], 'safe'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate(['imageFiles'])) {
            foreach ($this->imageFiles as $file) {
                FileHelper::createDirectory("images/{$this->id}");
                $path = 'images/' . $this->id . '/' . $file->baseName . '.' . $file->extension;
                if($file->saveAs($path)){
                    $fileRecord = new GoodsImage();
                    $fileRecord->size = $file->size;
                    $fileRecord->path = $path;
                    $fileRecord->goods_id = $this->id;
                    $fileRecord->save();
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return void
     */
    public function deleteOldImages()
    {
        //GoodsImage::deleteAll(['goods_id' => $this->id]);
        foreach ($this->images as $image){
            $image->delete();
        }
        FileHelper::removeDirectory('images/' . $this->id);
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
     */
    public function getImages()
    {
        return $this->hasMany(GoodsImage::class, ['goods_id' => 'id']);
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
