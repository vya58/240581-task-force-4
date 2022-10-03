<?php

namespace app\controllers;

use Yii;
use app\models\Executor;
use app\models\ExecutorCategoryQuery;
use app\models\ExecutorQuery;
use app\models\CustomerQuery;
use app\models\CategoryQuery;
use app\models\Task;
use app\models\TaskQuery;

class UserController extends \yii\web\Controller
{
    /**
     * Страница просмотра профиля исполнителя
     *
     * @return string - код страницы просмотра задания
     */

    public function actionView()
    {

        $executor = new Executor();

        $request = Yii::$app->request;

        $executorId = $request->get('id');

        $executorCategoriesId = ExecutorCategoryQuery::selectExecutorCategoriesId($executorId);

        $executor = ExecutorQuery::selectExecutor($executorId);

        $city = $executor->city;

        $executorCategories = CategoryQuery::selectCategories($executorCategoriesId);

        $age = calculateAge($executor->executor_birthday);
        $executor =  $executor->setAge($age);

        $registationData = formatData($executor->executor_date_add);

        $executorTasks = TaskQuery::selectExecutorTasks($executorId);

        $phone = phone_format($executor->executor_phone);

        $executorInformation = [
            'countGrade' => 0,
            'sumGrade' => 0,
            'countFail' => 0,
            'registretionDate' => $registationData,
            'status' => $executor->executor_status,
            'phone' => $phone,
            'email' => $executor->executor_email,
            'telegram' => $executor->executor_telegram,
        ];


        $status = [];

        foreach ($executorTasks as  $executorTask) {
            $customer = CustomerQuery::selectCustomer($executorTask->customer_id);

            $customersInformation[$customer[0]['customer_id']]['customer_avatar'] = $customer[0]['customer_avatar'];
            
            if (Task::STATUS_FAILED === $executorTask->task_status) {
                $status[] = $executorTask->task_status;
            }

            if (0 !== $executorTask->grade) {
                $executorInformation['countGrade'] = $executorInformation['countGrade'] + 1;
            }
            $executorInformation['sumGrade'] = $executorInformation['sumGrade'] + $executorTask->grade;
        }

        $executorInformation['countFail'] = count($status);

        return $this->render(
            'view',
            [
                'executor' => $executor,
                'executorCategories' => $executorCategories,
                'city' => $city,
                'executorTasks' => $executorTasks,
                'executorInformation' => $executorInformation,
                'customersInformation' => $customersInformation,
            ]
        );
    }
}
