<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Executor]].
 *
 * @see Executor
 */
class ExecutorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Executor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Executor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
