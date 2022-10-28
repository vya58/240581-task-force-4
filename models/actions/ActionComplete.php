<?php

namespace app\models\actions;

class ActionComplete extends ActionAbstract
{
    public function getActionName(): string
    {
        return 'Завершить задание';
    }

    public function getInternalName(): string
    {
        return 'actionComplet';
    }

    public function getLink(): ?string
    {
        return null;
    }

    public function getStyleClass(): string
    {
        return 'pink';
    }

    public function getDataAction(): string
    {
        return 'completion';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool {
        return $userId === $customerId;
    }
}
