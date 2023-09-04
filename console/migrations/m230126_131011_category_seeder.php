<?php

use yii\db\Migration;

/**
 * Class m230126_131011_category_seeder
 */
class m230126_131011_category_seeder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        for ($i=0; $i < 10; $i++){
//            $category = new \common\models\Category();
//            $category->name = "test category no.".($i+1);
//            $category->description = "this category was created for simple testing purposes";
//
//            if(!$category->save()){
//                throw new \yii\db\Exception("the simple test category could not be saved");
//            }
//        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $categories = \common\models\Category::find()->where(['like', 'name', 'test category'])->all();
//        foreach ($categories as $category){
//            $category->delete();
//        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230126_131011_category_seeder cannot be reverted.\n";

        return false;
    }
    */
}
