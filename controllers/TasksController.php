<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\TaskfilterForm;
use app\models\Category;

class TasksController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tasksFilter = new TaskFilterForm();

        if (Yii::$app->request->getIsPost()) {
            $tasksFilter->load(Yii::$app->request->post());
        }

        $query = Task::find()
            ->where(
                ['task_status' => Task::STATUS_NEW]
            );

        if ($tasksFilter->categories) {
            $query->andWhere(
                ['category_id' => $tasksFilter->categories]
            );
        }

        if ($tasksFilter->distantWork) {
            $query->andWhere(
                ['task_latitude' => null]
            );
        }

        if ($tasksFilter->noResponse) {
            $query->andWhere(
                ['executor_id' => null]
            );
        }

        if ($tasksFilter->period) {
            $query->andWhere(
                'task_date_create >= NOW() - INTERVAL ' . $tasksFilter->period . ' HOUR'
            );
        }

        $categories = Category::find()
            ->select('category_name')
            ->indexBy('category_id')
            ->column();

        $tasks = $query->orderBy(
            ['task_date_create' => SORT_DESC]
        )
            ->all();

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
