<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pictures}}`.
 */
class m230124_171545_create_pictures_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pictures}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),//this might be troubling in the future
            'size' => $this->integer(),
            'height' => $this->integer(),
            'width' => $this->integer(),
            'goods_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultValue('NOW()'),
            'updated_at' => $this->timestamp()->defaultValue('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pictures}}');
    }
}
