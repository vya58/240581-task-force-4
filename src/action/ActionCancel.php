<?php

namespace TaskForce\action;

class ActionCancel extends Action
{
    public function getActionName(): string
    {
        return 'Отменить';
    }

    public function getInternalName(): string
    {
        return 'actionCancel';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        ?int $executorId = null
    ): bool {
        return $userId === $customerId;
    }
}
