<?php

namespace app\models\forms;

use Yii;
use TaskForce\exceptions\DataSaveException;
use yii\base\Model;
use app\models\Category;
use app\models\File;
use app\models\Task;

class TaskCreateForm extends Model
{
    public $taskName;
    public $taskEssence;
    public $taskDetails;
    public $category;
    // public $location;
    public $taskBudget;
    public $taskDeadline;
    public $files;

    public function attributeLabels()
    {
        return [
            'taskName' => 'Название задания',
            'taskEssence' => 'Мне нужно',
            'taskDetails' => 'Подробности задания',
            'category' => 'Категория задания',
            //'location' => 'Локация',
            'taskBudget' => 'Бюджет',
            'taskDeadline' => 'Срок исполнения',
            'files' => 'Файлы',
        ];
    }

    public function rules()
    {
        return [
            [['taskName', 'taskEssence', 'taskDetails', 'category'], 'required'],
            ['taskName', 'string', 'min' => 3, 'max' => 50],
            ['taskEssence', 'string', 'min' => 10, 'max' => 255],
            ['taskDetails', 'string', 'min' => 10],
            [['taskDeadline'], 'date', 'when' => function ($form) {
                return strtotime($form->taskDeadline) < time();
            }, 'message' => 'Дата выполнения задания не может быть раньше текущей даты'],
            ['category', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'category_id']],
            ['taskBudget', 'integer', 'min' => 0],
            [['files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }

    public function addTask()
    {
        $task = new Task();

        $task->task_status = Task::STATUS_NEW;
        $task->task_name = $this->taskName;
        $task->task_essence = $this->taskEssence;
        $task->task_details = $this->taskDetails;
        $task->category_id = $this->category;
        $task->task_deadline = $this->taskDeadline;
        $task->task_budget = $this->taskBudget;
        $task->customer_id = Yii::$app->user->id;

        if (!$task->save()) {
            throw new DataSaveException('Ошибка сохранения задания');
        }

        return  $task;
    }

    public function uploadFiles($taskId)
    {
        if ($this->validate() && !empty($this->files)) {
            foreach ($this->files as $file) {
                // Базовое имя будет использоваться для публичного отображения имени файла в удобочитаемом формате на усмотрение пользователя
                $addedFileBaseName = $file->baseName;
                // Уникальное именя файла в БД 
                $addedFileName = md5(microtime(true)) . '.' . $file->extension;
                $file->saveAs('@app/web/uploads/' . $addedFileName);
                $addedFile = new File();
                $addedFile->task_id = $taskId;
                $addedFile->task_file_name = $addedFileName;
                $addedFile->task_file_base_name = $addedFileBaseName;

                if (!$addedFile->save()) {
                    throw new DataSaveException('Ошибка загрузки файла задания');
                }
            }
            return true;
        }
        return false;
    }
}
