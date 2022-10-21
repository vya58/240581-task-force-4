<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use app\models\User;
use app\models\helpers\CalculateHelper;
use app\models\helpers\FormatDataHelper;
use yii\web\NotFoundHttpException;

class UserController extends SecuredController
{
    /**
     * Страница просмотра профиля исполнителя
     *
     * @return string - код страницы просмотра задания
     */

    public function actionView(int $id)
    {
        $executor = User::find()
            ->with('city', 'categories', 'executorTasks')
            ->where(['user_id' => $id])
            ->andWhere(['user_role' => User::ROLE_EXECUTOR])
            ->one();

        if (!$executor) {
            throw new NotFoundHttpException();
        }

        $city = $executor->city;

        $executorCategories = $executor->categories;

        $executorTasks = $executor->executorTasks;

        $taskCustomers = Task::find()
            ->with('customer')
            ->where(['executor_id' => $id])
            ->all();

        $executorAge = CalculateHelper::calculateAge($executor->birthday);

        $executorRatingPosition = CalculateHelper::calculateRating($executor->sumGrade, $executor->countGrade, $executor->failTasksCount);

        $executor->date_add = FormatDataHelper::formatData($executor->date_add);

        $executor->status = User::getExecutorStatusMap()[$executor->status];

        $executor->phone = FormatDataHelper::formatPhone($executor->phone);

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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return Yii::$app->response->redirect(['login']);
    }
}
