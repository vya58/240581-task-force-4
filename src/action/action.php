<?php
namespace TaskForce\action;

abstract class Action
{
    abstract public function getActionName(): string;

    abstract public function getInternalName(): string;

    abstract public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool;
}