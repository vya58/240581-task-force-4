<?php

namespace app\models\actions;

class ActionRefuse extends ActionAbstract
{
    public function getActionName(): string
    {
        return 'Отказаться от задания';
    }

    public function getInternalName(): string
    {
        return 'actionRefuse';
    }
    
    public function getLink(): ?string
    {
        return null;
    }

    public function getStyleClass(): string
    {
        return 'orange';
    }

    public function getDataAction(): string
    {
        return 'refusal';
    }

    public static function checkRights(
        int $userId,
        int $customerId,
        int $executorId
    ): bool {
        return $userId === $executorId;
    }
}
