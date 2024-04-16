<?php

use yii\db\Migration;
use yii\db\Schema;
/**
 * Handles the creation of table `{{%states}}`.
 */
class m240416_004404_create_states_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%states}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'sigla' => $this->string()->notNull(),
            'regiao_id' => $this->integer()->notNull()
        ]);

         $this->insert('states', ['id' => 11, 'nome' => 'Rondônia', 'sigla' => 'RO', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 12, 'nome' => 'Acre', 'sigla' => 'AC', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 13, 'nome' => 'Amazonas', 'sigla' => 'AM', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 14, 'nome' => 'Roraima', 'sigla' => 'RR', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 15, 'nome' => 'Pará', 'sigla' => 'PA', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 16, 'nome' => 'Amapá', 'sigla' => 'AP', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 17, 'nome' => 'Tocantins', 'sigla' => 'TO', 'regiao_id' => 1]);
         $this->insert('states', ['id' => 21, 'nome' => 'Maranhão', 'sigla' => 'MA', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 22, 'nome' => 'Piauí', 'sigla' => 'PI', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 23, 'nome' => 'Ceará', 'sigla' => 'CE', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 24, 'nome' => 'Rio Grande do Norte', 'sigla' => 'RN', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 25, 'nome' => 'Paraíba', 'sigla' => 'PB', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 26, 'nome' => 'Pernambuco', 'sigla' => 'PE', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 27, 'nome' => 'Alagoas', 'sigla' => 'AL', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 28, 'nome' => 'Sergipe', 'sigla' => 'SE', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 29, 'nome' => 'Bahia', 'sigla' => 'BA', 'regiao_id' => 2]);
         $this->insert('states', ['id' => 31, 'nome' => 'Minas Gerais', 'sigla' => 'MG', 'regiao_id' => 3]);
         $this->insert('states', ['id' => 32, 'nome' => 'Espírito Santo', 'sigla' => 'ES', 'regiao_id' => 3]);
         $this->insert('states', ['id' => 33, 'nome' => 'Rio de Janeiro', 'sigla' => 'RJ', 'regiao_id' => 3]);
         $this->insert('states', ['id' => 35, 'nome' => 'São Paulo', 'sigla' => 'SP', 'regiao_id' => 3]);
         $this->insert('states', ['id' => 41, 'nome' => 'Paraná', 'sigla' => 'PR', 'regiao_id' => 4]);
         $this->insert('states', ['id' => 42, 'nome' => 'Santa Catarina', 'sigla' => 'SC', 'regiao_id' => 4]);
         $this->insert('states', ['id' => 43, 'nome' => 'Rio Grande do Sul', 'sigla' => 'RS', 'regiao_id' => 4]);
         $this->insert('states', ['id' => 50, 'nome' => 'Mato Grosso do Sul', 'sigla' => 'MS', 'regiao_id' => 5]);
         $this->insert('states', ['id' => 51, 'nome' => 'Mato Grosso', 'sigla' => 'MT', 'regiao_id' => 5]);
         $this->insert('states', ['id' => 52, 'nome' => 'Goiás', 'sigla' => 'GO', 'regiao_id' => 5]);
         $this->insert('states', ['id' => 53, 'nome' => 'Distrito Federal', 'sigla' => 'DF', 'regiao_id' => 5]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%states}}');
    }
}
