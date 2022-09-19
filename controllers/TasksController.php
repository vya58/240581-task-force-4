<?php

namespace app\controllers;

use app\models\Task;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()
            ->where(['task_status' => Task::getStatusMap()['statusNew']])
            ->orderBy(['task_date_create' => SORT_DESC])
            ->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
