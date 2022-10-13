<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respond".
 *
 * @property int $respond_id
 * @property int $executor_id
 * @property int $task_id
 * @property int|null $accepted
 * @property int|null $challenger_price
 * @property string $date_add
 * @property string|null $promising_message
 *
 * @property User $executor
 * @property Task $task
 */
class Respond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'task_id'], 'required'],
            [['executor_id', 'task_id', 'accepted', 'challenger_price'], 'integer'],
            [['date_add'], 'safe'],
            [['promising_message'], 'string', 'max' => 255],
            [['task_id', 'executor_id'], 'unique', 'targetAttribute' => ['task_id', 'executor_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'user_id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'task_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'respond_id' => 'ID отклика',
            'executor_id' => 'ID исполнителя',
            'task_id' => 'ID задания',
            'accepted' => 'Принято к исполнению',
            'challenger_price' => 'Цена исполнителя',
            'date_add' => 'Дата отклика',
            'promising_message' => 'Сообщение исполнителя',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['user_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['task_id' => 'task_id']);
    }
}
