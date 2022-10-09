<?php

namespace app\controllers;

use app\models\Executor;
use app\models\Task;
use app\models\helpers\CalculateHelper;
use app\models\helpers\FormatDataHelper;
use yii\web\NotFoundHttpException;

class UserController extends \yii\web\Controller
{
    /**
     * Страница просмотра профиля исполнителя
     *
     * @return string - код страницы просмотра задания
     */

    public function actionView(int $id)
    {
        $executor = Executor::find()
            ->with('city', 'categories', 'tasks')
            ->where(['executor_id' => $id])
            ->one();

        if (!$executor) {
            throw new NotFoundHttpException();
        }

        $city = $executor->city;

        $executorCategories = $executor->categories;

        $executorTasks = $executor->tasks;

        $taskCustomers = Task::find()
            ->with('customer')
            ->where(['executor_id' => $id])
            ->all();

        $executorAge = CalculateHelper::calculateAge($executor->executor_birthday);

        $executorRatingPosition = CalculateHelper::calculateRating($executor->sumGrade, $executor->countGrade, $executor->failTasksCount);

        $executor->executor_date_add = FormatDataHelper::formatData($executor->executor_date_add);

        $executor->executor_status = Executor::getStatusMap()[$executor->executor_status];

        $executor->executor_phone = FormatDataHelper::formatPhone($executor->executor_phone);

        return $this->render(
            'view',
            [
                'executor' => $executor,
                'executorCategories' => $executorCategories,
                'city' => $city,
                'executorTasks' => $executorTasks,
                'taskCustomers' => $taskCustomers,
                'executorAge' => $executorAge,
                'executorRatingPosition' => $executorRatingPosition,
            ]
        );
    }
}
