<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m240416_011030_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'document' => $this->string()->notNull(),
            'image' => $this->text()->notNull(),
            'gender_id' => $this->tinyInteger()->notNull(),
            'address_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey('fk_clients_genders', '{{%clients}}', 'gender_id', '{{%genders}}', 'id');
        $this->addForeignKey('fk_clients_clients_address', '{{%clients}}', 'address_id', '{{%clients_address}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
