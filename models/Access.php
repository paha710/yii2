<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $date
 *
 */
class Access extends \yii\db\ActiveRecord
{
    const ACCESS_CREATOR = 1;
    const ACCESS_GUEST = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guest'], 'required'],
            [['user_owner', 'user_guest'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_owner' => Yii::t('app', 'Автор записи'),
            'user_guest' => Yii::t('app', 'Гость'),
            'date' => Yii::t('app', 'Дата'),
        ];

    }

    /**
     * @param Calendar $model
     * @return bool|int
     */
    public function checkAccess($model){
        if($model->creator == Yii::$app->user->id)
        { 
            return self::ACCESS_CREATOR;
        }
      
        $accessCalendar = self::find()
            ->withUser(Yii::$app->user->id)
            ->withDate($model->date_event)
            ->exists();
        if($accessCalendar)
            return self::ACCESS_GUEST;
        
        return false;
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOwner ()
    {
        return $this->hasOne(User::className(),['user_owner' => 'id']);
    }

    public function beforeSave ($insert)
    {
        if ($this->getIsNewRecord())
        {
            $this->user_owner = Yii::$app->user->id;
        }

        parent::beforeSave($insert);

        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGuest ()
    {
        return $this->hasMany(User::className(), ['user_guest' => 'id']);
    }
    /**
     * @inheritdoc
     * @return \app\models\query\AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AccessQuery(get_called_class());
    }
}
