<?php

namespace TaskForce\action;

class ActionRefuse extends Action {
    public function getActionName(): string {
        return 'Отказаться';
    }

    public function getInternalName(): string {
        return 'actionRefuse';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool {
        return $userId === $executorId;
    }
}