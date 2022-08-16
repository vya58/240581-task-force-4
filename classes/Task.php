<?php

// Класс, представляющий сущность "Задание"
class Task
{
    private int $customer_id;
    private ?int $executor_id;
    private string $current_status = self::STATUS_NEW;

    const STATUS_NEW = 'status_new';
    const STATUS_CANCELED = 'status_canceled';
    const STATUS_IN_WORK = 'status_in_work';
    const STATUS_PERFORMED = 'status_performed';
    const STATUS_FAILED = 'status_failed';
    const ACTION_CANCEL = 'action_cancel';
    const ACTION_RESPOND = 'action_respond';
    const ACTION_EXECUTE = 'action_execute';
    const ACTION_REFUSE = 'action_refuse';

    public function __construct(int $customer_id, int $executor_id = null)
    {
        $this->executor_id = $executor_id;
        $this->customer_id = $customer_id;
    }

    // Объект класса создаёт заказчик, исполнитель, скорее всего, подключится позже
    // Функция установки id исполнителя задания
    public function setExecutorId(int $executor_id)
    {
        $this->executor_id = $executor_id;
    }

    public function getCurrentStatus(): string
    {
        return $this->current_status;
    }

    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_PERFORMED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    public function getActionMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_EXECUTE => 'Завершено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    public function getNextStatus(string $action): string
    {
        if (!$action) {
            return false;
        }
        return match ($action) {
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::STATUS_IN_WORK,
            self::ACTION_EXECUTE => self::STATUS_PERFORMED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        };
    }

    public function getAvailableActions(int $id): string
    {
        if (!($id === $this->customer_id || $id === $this->executor_id)) {
            return false;
        }
        return match ($this->current_status) {
            self::STATUS_NEW => $id === $this->customer_id ? self::ACTION_CANCEL : self::ACTION_RESPOND,
            self::STATUS_IN_WORK => $id === $this->customer_id ? self::ACTION_EXECUTE : self::ACTION_REFUSE,
        };
    }

    // Функция для тестового сценария проверки класса
    public function setCurrentStatus(string $action = null): void
    {
        if ($action) {
            $this->current_status = $this->getNextStatus($action);
        } else {
            $this->current_status = self::STATUS_NEW;
        }
    }
}
