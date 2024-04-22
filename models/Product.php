<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $image
 * @property int $client_id
 *
 * @property Client $client
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'client_id', 'image'], 'required'],
            [['price'], 'number'],
            [['image'], 'imageValid'],
            [['client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'image' => 'Image',
            'client_id' => 'Client ID',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function imageValid($attribute)
    {
        $base64_image = $this->$attribute;
        $pattern = '/^data:image\/(png|jpg|jpeg);base64,/';
        // Verificar se a string corresponde ao padrão
        if (!preg_match($pattern, $base64_image) && !file_exists($base64_image)) {
            $this->addError($attribute, "Imagem inválida");
        } 
    }
}
