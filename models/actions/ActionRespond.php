<?php

namespace app\models\actions;

class ActionRespond extends ActionAbstract
{
    public function getActionName(): string
    {
        return 'Откликнуться на задание';
    }

    public function getInternalName(): string
    {
        return 'actionRespond';
    }

    public function getLink(): ?string
    {
        return null;
    }

    public function getStyleClass(): string
    {
        return 'blue';
    }

    public function getDataAction(): string
    {
        return 'act_response';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        ?int $executorId = null
    ): bool {
        return $userId !== $customerId;
    }
}
