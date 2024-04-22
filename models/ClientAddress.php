<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_address".
 *
 * @property int $id
 * @property string|null $street
 * @property string|null $neighborhood
 * @property string|null $complement
 * @property string|null $number
 * @property int|null $state_id
 * @property int|null $city_id
 *
 * @property City $city
 * @property Client[] $clients
 * @property State $state
 */
class ClientAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_id', 'city_id'], 'integer'],
            [['street', 'neighborhood', 'complement', 'number'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::class, 'targetAttribute' => ['state_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'street' => 'Street',
            'neighborhood' => 'Neighborhood',
            'complement' => 'Complement',
            'number' => 'Number',
            'state_id' => 'State ID',
            'city_id' => 'City ID',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Clients]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Client::class, ['address_id' => 'id']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::class, ['id' => 'state_id']);
    }
}
