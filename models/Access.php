<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $date
 */
class Access extends ActiveRecord
{
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
            [['user_owner', 'user_guest', 'date'], 'required'],
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
            'user_owner' => Yii::t('app', 'User Owner'),
            'user_guest' => Yii::t('app', 'User Guest'),
            'date' => Yii::t('app', 'Date'),
        ];
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
