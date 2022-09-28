<?php

namespace app\controllers;

use app\models\TaskfilterForm;
use app\models\CategoryQuery;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasksFilter = new TaskFilterForm();

        $tasks =  $tasksFilter->selectTasks($tasksFilter);

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
