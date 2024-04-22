<?php

namespace app\models;

use yii\web\IdentityInterface;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'login', 'password'], 'required'],
            [['name', 'login', 'password'], 'string', 'max' => 255],
            [['login'], 'unique'],
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
            'login' => 'Login',
            'password' => 'Password',
        ];
    }

    /**
     * Localiza uma identidade pelo ID informado
     *
     * @param string|int $id o ID a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao ID informado
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {

        $userId = null;
        foreach((array) Yii::$app->jwt->loadToken($token)->claims() as $item) {
            if(isset($item['uid'])) {
                $userId = $item['uid'];
                break;
            }
        }
    
        return static::find()
            ->where(['id' => $userId ])
            ->one();
    }


    public function afterSave($isInsert, $changedOldAttributes) {
		// Purge the user tokens when the password is changed
		if (array_key_exists('usr_password', $changedOldAttributes)) {
			\app\models\UserRefreshToken::deleteAll(['urf_userID' => $this->userID]);
		}

		return parent::afterSave($isInsert, $changedOldAttributes);
	}

    public function getId()
    {
        return $this->id;
    }
    /**
     * @return string a chave de autenticação do usuário atual
     */
    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}
