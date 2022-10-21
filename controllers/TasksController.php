<?php

namespace app\controllers;

use Yii;
use app\models\helpers\FormatDataHelper;
use app\models\Category;
use app\models\File;
use app\models\Task;
use app\models\User;
use app\models\forms\TaskCreateForm;
use app\models\forms\TaskfilterForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use TaskForce\exceptions\DataSaveException;

class TasksController extends SecuredController
{
    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['create'],
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return (Yii::$app->user->identity->user_role === User::ROLE_EXECUTOR);
                        },
                        'denyCallback' => function () {
                            return $this->redirect(['tasks/index']);
                        }

                    ],
                ],
            ],
        ];
    }
*/

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
     * Действие скачивания файла задания
     *
     */
    public function actionDownload($path)
    {
        return Yii::$app->response->sendFile('../web/uploads/' . $path)->send();
    }

    /**
     * Страница просмотра задания
     *
     * @return string - код страницы просмотра задания
     */
    public function actionView(int $id): string
    {
        $user = Yii::$app->user->getIdentity();

        $task = Task::find()
            ->with('category', 'executor', 'files')
            ->where(['task_id' => $id])
            ->one();

        $files = $task->files;

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
                'files' => $files,
            ]
        );
    }

    /**
     * Страница с формой создания задания
     * 
     * @return string - код страницы с формой создания задания
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->getIdentity();

        if (User::ROLE_EXECUTOR === $user->user_role) {
            $this->redirect(['tasks/index']);
        }

        $taskAddForm = new TaskCreateForm();
        if (Yii::$app->request->getIsPost()) {
            $taskAddForm->load(Yii::$app->request->post());

            $taskAddForm->files = UploadedFile::getInstances($taskAddForm, 'files');

            if ($taskAddForm->validate()) {
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $task = $taskAddForm->addTask();
                    $taskAddForm->uploadFiles($task->task_id);
                    $transaction->commit();

                    return Yii::$app->response->redirect(['tasks/view', 'id' => $task->task_id]);
                } catch (DataSaveException $e) {
                    $transaction->rollback();

                    throw new DataSaveException('Ошибка создания задания', $e);
                }
            }
        }
        return $this->render('create', ['taskAddForm' => $taskAddForm]);
    }
}
