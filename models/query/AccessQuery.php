<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Access]].
 *
 * @see \app\models\Access
 */
class AccessQuery extends \yii\db\ActiveQuery
{

    public function withUser($user_id)
    {
        return $this -> andWhere(
            'user_id = :user_id',
            [
                ":user_id" => $user_id
            ]
        );
    }

    public function withDate($date_event)
    {
        return $this -> andWhere(
            'date_event = :date_event',
            [
                ":date_event" => date_create($date_event)->Format('Y-m-d')
               
            ]
        );

    }
    /**
     * @inheritdoc
     * @return \app\models\Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}