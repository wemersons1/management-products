<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%clients_address}}`.
 */
class m240416_004503_create_clients_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients_address}}', [
            'id' => $this->primaryKey(),
            'street' => $this->string()->null(),
            'neighborhood'=> $this->string()->null(),
            'complement' => $this->string()->null(),
            'number' => $this->string()->null(),
            'state_id' => $this->integer()->null(),
            'city_id' => $this->integer()->null(),
        ]);

        $this->addForeignKey('fk_clients_address_state', '{{%clients_address}}', 'state_id', '{{%states}}', 'id');
        $this->addForeignKey('fk_clients_address_city', '{{%clients_address}}', 'city_id', '{{%cities}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients_address}}');
    }
}
