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
 * @property-read GoodsImage[] $images
 * @property-read GoodsAttributeValue[] $attributeValues
 * @property-read Attribute[] $attributeNames
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
            [['name', 'price'], 'required'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
            [['author_id'], 'exist', 'targetClass' => FrontendUser::class, 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']]
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
                    $fileRecord = GoodsImage::find()->where(['goods_id' => $this->id])->andWhere(['path' => $path])->one() ?? new GoodsImage();
                    $fileRecord->size = $file->size;
                    $fileRecord->path = $path;
                    $fileRecord->goods_id = $this->id;
                    $fileRecord->save();

                    $im = new \Imagick($path);
                    $fileRecord->height = $im->getImageHeight();
                    $fileRecord->width = $im->getImageWidth();
                    $fileRecord->save();
                }
            }
            return true;
        } else {
//            var_dump($this->errors);die();
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
     * @return void
     *
     * Applies attributes received from POST to this Goods model
     */
    public function configureAttributes($attributes)
    {
//        if (\Yii::$app->request->post('deleteOldAttributes')){
//            GoodsAttributeValue::deleteAll(['goods_id' => $this->id]);
//        }
        if (isset($attributes)){
            /**
             * @var Attribute[] $attributeRecords
             */
            $attributeRecords = Attribute::find()->where(['in', 'id', array_keys($attributes)])->all();
            foreach ($attributeRecords as $attributeRecord){
                $attributeValue = Attribute::getValueFor($attributeRecord->id, $attributeRecord->type, $this->id)
                    ?? $attributeRecord->newGoodsAttributeValue($attributeRecord->type);

                if ($attributeValue->isNewRecord){
                    $attributeValue->goods_id = $this->id;
                    $attributeValue->attribute_id = $attributeRecord->id;
                }
                $attributeValue->value = $attributes[$attributeRecord->id];
                $attributeValue->save();
            }
        }
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
     */
    public function getAttributeNames()
    {
        return $this->hasMany(Attribute::class, ['id' => 'goods_id'])->viaTable('goodsAttributes', ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(GoodsAttributeValue::class, ['goods_id' => 'id']);
    }

    public function getOrders(){
        return $this->hasMany(Order::class, ['id' => 'order_id'])->viaTable('orders_goods', ['goods_id' => 'id']);
    }

}
