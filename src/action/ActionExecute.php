<?php

namespace TaskForce\action;

class ActionExecute extends Action
{
    public function getActionName(): string
    {
        return 'Завершено';
    }

    public function getInternalName(): string
    {
        return 'actionExecute';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool {
        return $userId === $customerId;
    }
}
