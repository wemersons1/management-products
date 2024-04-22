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
            'image' => $this->text()->null(),
            'client_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_product_client', '{{%products}}', 'client_id', '{{%clients}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_product_client', '{{%products}}');

        $this->dropTable('{{%products}}');
    }
}
