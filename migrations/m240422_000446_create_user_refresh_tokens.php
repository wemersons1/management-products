<?php

use yii\db\Migration;

/**
 * Class m240422_000446_create_user_refresh_tokens
 */
class m240422_000446_create_user_refresh_tokens extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_refresh_tokens', [
            'user_refresh_tokenID' => $this->primaryKey(),
            'urf_userID' => $this->integer()->notNull(),
            'urf_token' => $this->string(1000)->notNull(),
            'urf_ip' => $this->string(50)->notNull(),
            'urf_user_agent' => $this->string(1000)->notNull(),
            'urf_created' => $this->dateTime()->notNull()->comment('UTC'),
        ]);

        // Add foreign key constraint referencing users table (assuming the table is named 'users')
        $this->addForeignKey(
            'fk_user_refresh_tokens_urf_userID',
            'user_refresh_tokens',
            'urf_userID',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_refresh_tokens_urf_userID', 'user_refresh_tokens');
        $this->dropTable('user_refresh_tokens');
    }
    
}
