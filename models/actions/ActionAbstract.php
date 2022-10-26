<?php

namespace app\models\actions;

abstract class ActionAbstract
{
    abstract public function getActionName(): string;

    abstract public function getInternalName(): string;

    abstract public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId,
    ): bool;
}
