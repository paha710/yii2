<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClndrUser]].
 *
 * @see ClndrUser
 */
class ClndrUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ClndrUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClndrUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}