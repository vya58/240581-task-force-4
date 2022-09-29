<?php

namespace app\controllers;

use Yii;
use app\models\TaskfilterForm;
use app\models\CategoryQuery;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasksFilter = new TaskFilterForm();

        $tasksFilter->load(Yii::$app->request->get());

        $tasks =  $tasksFilter->selectTasks();

        $categories = CategoryQuery::selectCategories();

        return $this->render(
            'index',
            [
                'tasks' => $tasks,
                'categories' => $categories,
                'tasksFilter' => $tasksFilter
            ]
        );
    }
}
