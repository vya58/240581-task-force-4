<?php

namespace app\models\actions;

use Yii;

class ActionCancel extends ActionAbstract
{
    public function getActionName(): string
    {
        return 'Отменить задание';
    }

    public function getInternalName(): string
    {
        return 'actionCancel';
    }

    public function getLink($task): string
    {
        return Yii::$app->urlManager->createUrl(['tasks/cancel', 'id' => $task->task_id]);
    }

    public function getStyleClass(): string
    {
        return 'orange';
    }

    public function getDataAction(): string
    {
        return 'cancel';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        ?int $executorId = null,
    ): bool {
        return $userId === $customerId;
    }
}
