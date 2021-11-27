<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accesslog}}`.
 */
class m211127_223155_create_accesslog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%accesslog}}', [
            'id' => $this->primaryKey(),
            'ip_address' => $this->string(),
            'request_at' => $this->dateTime(),
            'url' => $this->text(),
            'user_agent' => $this->text(),
            'os' => $this->string(),
            'architecture' => $this->string(),
            'browser' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%accesslog}}');
    }
}
