<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $document
 * @property string $image
 * @property int $gender_id
 * @property int|null $address_id
 *
 * @property ClientAddress $address
 * @property Gender $gender
 * @property Product[] $products
 */
class Client extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'document', 'gender_id', 'image'], 'required'],
            [['image'], 'imageValid'],
            [['document'], 'cpfValid'],
            [['gender_id', 'address_id'], 'integer'],
            [['name', 'document'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientAddress::class, 'targetAttribute' => ['address_id' => 'id']],
            [['gender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::class, 'targetAttribute' => ['gender_id' => 'id']],
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
            'document' => 'Document',
            'image' => 'Image',
            'gender_id' => 'Gender ID',
            'address_id' => 'Address ID',
        ];
    }

    /**
     * Gets query for [[Address]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(ClientAddress::class, ['id' => 'address_id']);
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::class, ['id' => 'gender_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['client_id' => 'id']);
    }


    public function cpfValid($attribute)
    {
        if(!$this->cpfIsValid($this->$attribute)) {
            $this->addError($attribute,'CPF INVÁLIDO');
        }
    }

    private function cpfIsValid($cpf)
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
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
