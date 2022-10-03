<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\ExecutorQuery;
use app\models\TaskfilterForm;
use app\models\CategoryQuery;
use app\models\RespondQuery;

class TasksController extends \yii\web\Controller
{
    /**
     * Страница со списком заданий
     *
     * @return string - код страницы со списком заданий
     */
    public function actionIndex(): string
    {
        $tasksFilter = new TaskFilterForm();

        $tasksFilter->load(Yii::$app->request->get());

        $tasks =  $tasksFilter->selectNewTasks();

        $categories = CategoryQuery::selectAllCategories();

        return $this->render(
            'index',
            [
                'tasks' => $tasks,
                'categories' => $categories,
                'tasksFilter' => $tasksFilter
            ]
        );
    }

    /**
     * Страница просмотра задания
     *
     * @return string - код страницы просмотра задания
     */
    /**
     * Показывает страницы просмотра задачи
     *
     * @return string
     */
    public function actionView()
    {
        $task = new Task();

        $request = Yii::$app->request;

        $taskId = $request->get('id');

        $task =  $task->selectTask($taskId);

        $deadline = formatData($task['task_deadline']);

        $challengers = RespondQuery::selectChallengers($taskId);

        $category = $task['category'];

        $challengerInformation = [
            'executor_id' => '',
            'executor_name' => '',
            'executor_avatar' => '',
            'task_id' => null,
            'price' => null,
            'date_add' => null,
            'promising_message' => '',
            'countTasks' => null,
        ];

        $challengersInformation = [];

        foreach ($challengers as $challenger) {
            $challengerInformation['executor_id'] = $challenger->executor_id;
            $challengerInformation['price'] = $challenger->challenger_price;
            $challengerInformation['date_add'] = $challenger->date_add;
            $challengerInformation['promising_message'] = $challenger->promising_message;

            $applicant = ExecutorQuery::selectChallenger($challenger->executor_id);

            $challengerInformation['executor_name'] = $applicant->executor_name;
            $challengerInformation['countTasks'] = $applicant->count_tasks;
            $challengerInformation['executor_avatar'] = $applicant->executor_avatar;

            $challengersInformation[] = $challengerInformation;
        }

        return $this->render(
            'view',
            [
                'task' => $task,
                'category' => $category,
                'challengersInformation' => $challengersInformation,
                'deadline' => $deadline,
            ]
        );
    }
}
