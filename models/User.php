<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $token
 * @property string $auth_key
 * @property int $status
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
	const ACTIVE_USER = 1;
	const INACTIVE_USER = 0;
	
	
    public static function tableName()
    {
        // return '{{%user}}';
        return 'user';
    }
	
		
    public function rules()
    {
        return [
            [['nome', 'email', 'token', 'username', 'password'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nome', 'email', 'username', 'password'], 'string', 'max' => 255],
            [['token', 'auth_key'], 'string', 'max' => 32],
            [['username', 'email', 'token'], 'unique'],
			[['status'], 'default', 'value'=>self::ACTIVE_USER],
			['status', 'in', 'range'=>[self::ACTIVE_USER, self::INACTIVE_USER]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
            'token' => 'Token',
            'username' => 'Username',
            'password' => 'Senha',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }
	
	
    public static function findIdentity($id)
	{
		// return isset(self::$users[$id]) ? new static($users[$id]) : null;
		return static::findOne(['id'=>$id, 'status'=>self::ACTIVE_USER]);
	}
	
    public static function findIdentityByAccessToken($token, $type=null)
	{
		return static::findOne(['token'=>$token, 'status'=>self::ACTIVE_USER]);
	}

    public static function findByUsername($username)
    {
		// Irá buscar o usuário no USERNAME ou como EMAIL
		return static::find()->where(['username'=>$username])
			->orwhere(['email'=>$username])
			->andwhere(['status'=>self::ACTIVE_USER])
			->one();
    }
	
	public function getId()
	{
		return $this->getPrimaryKey();
	}
	
	public function getAuthKey()
	{
		return $this->auth_key;
	}
	
	
	/* Senha, AuthKey e Token */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
	
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString(32);
	}

	public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
	
	public function generateToken()
	{
		$this->token = Yii::$app->security->generateRandomString(32);
	}

}
