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
class ClndrUser extends  ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    const MAX_LENGTH_USERNAME = 128;
    const MAX_LENGTH_NAME = 45;
    const MIN_LENGTH_PASS = 6;
    
    public static function tableName()
    {
        return 'clndr_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'surname', 'password', 'salt'], 'required'],
            [['create_date'], 'safe'],
            [['username'], 'string', 'max' => self::MAX_LENGTH_USERNAME],
            [['name', 'surname'], 'string', 'max' => self::MAX_LENGTH_NAME],
            [['password', 'salt', 'access_token'], 'string', 'min' => self::MIN_LENGTH_PASS],
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
            'surname' => Yii::t('app', 'Фамилия'),
            'password' => Yii::t('app', 'Пароль'),
            'salt' => Yii::t('app', 'Соль'),
            'access_token' => Yii::t('app', 'Ключ доступа'),
            'create_date' => Yii::t('app', 'Дата создания'),
        ];
    }

    /**
     * @inheritdoc
     * @return ClndrUserQuery the active query used by this AR class.
     */
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

    public function saltGenerator ()
    {
        return hash("sha512", uniqid('salt_', true));
    }

    public function passWithSalt ($password, $salt)
    {
        return hash("sha512", $password . $salt);
    }

    public static function findIdentity ($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken ($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername ($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId ()
    {
        return $this->id;
    }

    public function getAuthKey ()
    {
        return $this->access_token;
    }

    public function validateAuthKey ($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword ($password)
    {
        return $this->password === $this->passWithSalt($password, $this->salt);
    }

    public function setPassword ($password)
    {
        $this->password = $this->passWithSalt($password, $this->saltGenerator());
    }

    public function generateAuthKey ()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }


}
