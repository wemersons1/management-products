<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%genders}}`.
 */
class m240416_003499_create_genders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%genders}}', [
            'id' => $this->tinyInteger()->notNull(),
            'name' => $this->string()->notNull()
        ]);

        $this->createIndex('gender_id_index', 'genders', 'id');

        $this->insert('genders', [
            'id' => 1,
            'name' => 'masculino',
        ]);

        $this->insert('genders', [
            'id' => 2,
            'name' => 'feminino',
        ]);

        $this->insert('genders', [
            'id' => 3,
            'name' => 'indefinido',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%genders}}');
    }
}
