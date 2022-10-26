<?php

namespace app\controllers;

use Yii;
use app\models\helpers\FormatDataHelper;
use app\models\Category;
use app\models\Respond;
use app\models\Task;
use app\models\User;
use app\models\forms\TaskCreateForm;
use app\models\forms\TaskfilterForm;
use app\models\forms\RespondForm;
use app\models\forms\CompleteForm;
use TaskForce\exceptions\DataSaveException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\web\Response;

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
     * Действие скачивания файла задания
     *
     */
    public function actionDownload($path)
    {
        return Yii::$app->response->sendFile(Yii::getAlias('@webroot/uploads/') . $path)->send();
    }

    /**
     * Страница просмотра задания
     *
     * @return string - код страницы просмотра задания
     */
    public function actionView(int $id): Response|string
    {
        $user = Yii::$app->user->getIdentity();

        $responseForm = new RespondForm();
        $completeForm = new CompleteForm();

        $task = Task::find()
            ->with('category', 'executor', 'files', 'responds')
            ->where(['task_id' => $id])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException();
        }

        if (User::ROLE_CUSTOMER === $user->user_role && $task->customer->user_id !== $user->user_id) {
            return $this->goHome();
        }

        $files = $task->files;

        $deadline = FormatDataHelper::formatData($task->task_deadline);

        $responses = $task->responds;

        $category = $task->category;

        if ($user->user_role === User::ROLE_CUSTOMER && $task->customer->user_id !== $user->user_id) {
            return $this->goHome();
        }

        $showAvailableAction = false;

        // Показ кнопки возможного действия только для новых и находящихся в работе заданий
        if (Task::STATUS_NEW === $task->task_status || (Task::STATUS_IN_WORK === $task->task_status)) {
            $showAvailableAction = true;
        }

        $availableAction = $task->getAvailableActions($user);
       
        // Исключение возможности исполнителю добавить ещё один отклик на тоже задание
        if ($availableAction && Respond::getResponse($user->user_id, $task->task_id) && 'actionRespond' === $availableAction->getInternalName()) {
            $showAvailableAction = false;
        }

        return $this->render(
            'view',
            [
                'user' => $user,
                'task' => $task,
                'responses' => $responses,
                'category' => $category,
                'deadline' => $deadline,
                'files' => $files,
                'availableAction' => $availableAction,
                'showAvailableAction' => $showAvailableAction,
                'responseForm' => $responseForm,
                'completeForm' => $completeForm,
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

        if (User::ROLE_CUSTOMER !== $user->user_role) {
            return $this->goHome();
        }
        $taskAddForm = new TaskCreateForm();

        $taskAddForm = new TaskCreateForm();
        if (Yii::$app->request->getIsPost()) {

            $taskAddForm->load(Yii::$app->request->post());

            $taskAddForm->files = UploadedFile::getInstances($taskAddForm, 'files');

            if ($taskAddForm->validate()) {
                $taskAddForm->makeTransaction($taskAddForm);
            }
        }
        return $this->render('create', ['taskAddForm' => $taskAddForm]);
    }

    /**
     * Действие по отмене задания
     *
     */
    public function actionCancel($id)
    {
        $task = Task::findOne($id);

        if (Task::STATUS_NEW === $task->task_status) {
            $task->task_status = Task::STATUS_CANCELED;
            $task->date_completion = date("Y-m-d H:i:s");

            if (!$task->save()) {
                throw new DataSaveException('Ошибка отмены задания');
            }
        }
        return $this->redirect(['tasks/view', 'id' => $task->task_id]);
    }

    /**
     * Действие по отказу от отклика на задание
     *
     */
    public function actionReject(int $respond_id)
    {
        $response = Respond::processOffer($respond_id, Respond::STATUS_REJECTED);

        return $this->redirect(['tasks/view', 'id' => $response->task_id]);
    }

    /**
     * Действие по принятию отклика на задание
     *
     */
    public function actionAccept(int $respond_id)
    {
        $response = Respond::processOffer($respond_id, Respond::STATUS_ACCEPTED);

        return $this->redirect(['tasks/view', 'id' => $response->task_id]);
    }

    /**
     * Действие по отклику на задание
     *
     */
    public function actionRespond()
    {
        $responseForm = new RespondForm();
        if (Yii::$app->request->getIsPost()) {
            $responseForm->load(Yii::$app->request->post());

            if ($responseForm->validate() && $responseForm->createResponse()) {

                return Yii::$app->response->redirect(['tasks/view', 'id' => $responseForm->taskId]);
            }
        }
        return $this->goHome();
    }

    /**
     * Действие по отказу от задания
     *
     */
    public function actionRefuse(int $id)
    {
        $task = Task::findOne($id);
        $task->task_status = Task::STATUS_FAILED;
        $task->date_completion = date("Y-m-d H:i:s");

        if (!$task->save()) {
            throw new DataSaveException('Ошибка отказа от задания');
        }

        return $this->redirect(['tasks/view', 'id' => $task->task_id]);
    }

    /**
     * Действие завершению задания пользователем
     *
     */
    public function actionComplete()
    {
        $completeForm = new CompleteForm();

        if (Yii::$app->request->getIsPost()) {
            $completeForm->load(Yii::$app->request->post());

            if ($completeForm->validate() && $completeForm->createComplete()) {
                return Yii::$app->response->redirect(['tasks/view', 'id' => $completeForm->taskId]);
            }
        }
        return $this->goHome();
    }
}
