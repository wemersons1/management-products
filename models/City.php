<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property int $estado_id
 * @property string $nome
 *
 * @property ClientAddress[] $clientsAddresses
 * @property State $estado
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_id', 'nome'], 'required'],
            [['estado_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::class, 'targetAttribute' => ['estado_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'estado_id' => 'Estado ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[ClientsAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClientsAddresses()
    {
        return $this->hasMany(ClientAddress::class, ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(State::class, ['id' => 'estado_id']);
    }
}
