<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $file_id
 * @property int|null $task_id
 * @property string $task_file_name
 * @property string $task_file_base_name
 *
 * @property Task $task
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'integer'],
            [['task_file_name'], 'required'],
            [['task_file_name'], 'unique'],
            [['task_file_name', 'task_file_base_name'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'task_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'ID файла',
            'task_id' => 'ID задания',
            'task_file_name' => 'Файл задания',
            'task_file_base_name' => 'Публичное имя файла задания',
        ];
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
