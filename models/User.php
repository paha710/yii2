<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "clndr_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $surname
 * @property string $password
 * @property string $salt
 * @property string $access_token
 * @property string $create_date
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    const MAX_LENGTH_USERNAME = 128;
    const MAX_LENGTH_SURNAME = 45;
    const  MIN_LENGTH_PASS = 6;
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password'], 'required'],
            [['create_date'], 'safe'],
            [['username'], 'string', 'max' => self::MAX_LENGTH_USERNAME],
            [['name', 'surname'], 'string', 'max' => self::MAX_LENGTH_SURNAME],
            [['password'], 'string', 'min' => self::MIN_LENGTH_PASS],
            [['username'], 'unique'],
            [['access_token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Логин'),
            'name' => Yii::t('app', 'Имя'),
            'surname' => Yii::t('app', 'Отчество'),
            'password' => Yii::t('app', 'Пароль'),
            'salt' => Yii::t('app', 'Соль'),
            'access_token' => Yii::t('app', 'Ключ доступа'),
            'create_date' => Yii::t('app', 'Дата создания'),
        ];
    }

    public function beforeSave ($insert)
    {
        if (parent::beforeSave($insert))
        {
            if ($this->getIsNewRecord() && !empty($this->password))
            {
                $this->salt = $this->saltGenerator();
            }
            if (!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password, $this->salt);
            }
            else
            {
                unset($this->password);
            }
            return true;
        }
        else
        {
            return false;
        }
    }
    /**
     * Generate the salt
     * @return string
     */
    public function saltGenerator ()
    {
        return hash("sha512", uniqid('salt_', true));
    }
    /**
     * Return pass with the salt
     * @param $password
     * @param $salt
     * @return string
     */
    public function passWithSalt ($password, $salt)
    {
        return hash("sha512", $password . $salt);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity ($id)
    {
        return static::findOne(['id' => $id]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken ($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername ($username)
    {
        return static::findOne(['username' => $username]);
    }
    /**
     * @inheritdoc
     */
    public function getId ()
    {
        return $this->id;
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey ()
    {
        return $this->access_token;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey ($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword ($password)
    {
        return $this->password === $this->passWithSalt($password, $this->salt);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword ($password)
    {
        $this->password = $this->passWithSalt($password, $this->saltGenerator());
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey ()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }
}
