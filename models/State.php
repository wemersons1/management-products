<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property int $id
 * @property string $nome
 * @property string $sigla
 * @property int $regiao_id
 *
 * @property City[] $cities
 * @property ClientAddress[] $clientsAddresses
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'sigla', 'regiao_id'], 'required'],
            [['regiao_id'], 'integer'],
            [['nome', 'sigla'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'sigla' => 'Sigla',
            'regiao_id' => 'Regiao ID',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['estado_id' => 'id']);
    }

    /**
     * Gets query for [[ClientsAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientsAddresses()
    {
        return $this->hasMany(ClientAddress::class, ['state_id' => 'id']);
    }
}
