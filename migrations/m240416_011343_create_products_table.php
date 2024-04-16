<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m240416_011343_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal(8, 2)->notNull(),
            'image' => $this->text()->notNull(),
            'client_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
