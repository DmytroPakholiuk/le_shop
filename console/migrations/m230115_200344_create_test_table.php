<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 */
class m230115_200344_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->defaultValue('asdasdasd'),
            'status' => $this->smallInteger(),
            'cteated_at' => $this->timestamp()->defaultValue('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test}}');
    }
}
