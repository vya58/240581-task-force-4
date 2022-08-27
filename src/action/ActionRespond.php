<?php

namespace TaskForce\action;

class ActionRespond extends Action {
    public function getActionName(): string {
        return 'Откликнуться';
    }

    public function getInternalName(): string {
        return 'actionRespond';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool {
        return $userId === $executorId;
    }
}