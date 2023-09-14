<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegram_voices}}`.
 */
class m230525_143817_create_telegram_voices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%telegram_voices}}');
    }
}
