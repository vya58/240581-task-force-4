<?php

namespace app\controllers;

use app\models\Task;
use app\models\Category;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()
            ->where(['task_status' => '0'])
            ->orderBy(['task_date_create' => SORT_DESC])
            ->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
