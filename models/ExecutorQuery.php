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

    public static function selectChallengers(array $challengers)
    {
        $challengersId = [];

        foreach ($challengers as $challenger) {
            $challengersId[] = $challenger->executor_id;
        }
        return Executor::find()
            ->where(['in', 'executor_id', $challengersId])
            ->all();
    }

    public static function selectChallenger($id)
    {
        return Executor::findOne(['executor_id' => $id]);
    }

    public static function selectExecutor($id)
    {
        return Executor::find()
            ->with('city')
            ->where(['executor_id' => $id])
            ->one();
    }

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
