<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "executor_task".
 *
 * @property int $id
 * @property int $executor_id
 * @property int $task_id
 *
 * @property Executor $executor
 * @property Task $task
 */
class ExecutorTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executor_task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'task_id'], 'required'],
            [['executor_id', 'task_id'], 'integer'],
            [['task_id', 'executor_id'], 'unique', 'targetAttribute' => ['task_id', 'executor_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executor::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'task_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executor_id' => 'ID исполнителя',
            'task_id' => 'ID задания',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|ExecutorQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Executor::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['task_id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return ExecutorTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecutorTaskQuery(get_called_class());
    }
}
