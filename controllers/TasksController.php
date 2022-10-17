<?php

namespace app\controllers;

use Yii;
use app\models\helpers\FormatDataHelper;
use app\models\Category;
use app\models\Task;
use app\models\User;
use app\models\forms\TaskfilterForm;
use yii\web\NotFoundHttpException;

class TasksController extends SecuredController
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

        $tasks =  $tasksFilter->newTasks;

        $categories = Category::getAllCategories();

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
    public function actionView(int $id)
    {
        $user = Yii::$app->user->getIdentity();

        $task = Task::find()
            ->with('category', 'executor')
            ->where(['task_id' => $id])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException();
        }

        if (User::ROLE_CUCTOMER === $user->user_role && $task->customer->user_id !== $user->user_id) {
            $this->redirect(['tasks/index']);
        }

        $task->task_status = Task::getStatusMap()['New'];

        $deadline = FormatDataHelper::formatData($task->task_deadline);

        $responds = $task->responds;

        $category = $task->category;

        return $this->render(
            'view',
            [
                'task' => $task,
                'responds' => $responds,
                'category' => $category,
                'deadline' => $deadline,
            ]
        );
    }
}
