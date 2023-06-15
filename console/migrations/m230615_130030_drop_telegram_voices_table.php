<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%telegram_voices}}`.
 */
class m230615_130030_drop_telegram_voices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%telegram_voices}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%telegram_voices}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'chat_id' => $this->integer(),
            'user_id' => $this->integer(),
            'file_size' => $this->integer(),
            'file_id' => $this->string()
        ]);
    }
}
