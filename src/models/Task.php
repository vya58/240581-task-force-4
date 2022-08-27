<?php
// Класс, представляющий сущность "Задание"

namespace TaskForce\models;

use TaskForce\action\ActionCancel;
use TaskForce\action\ActionRespond;
use TaskForce\action\ActionExecute;
use TaskForce\action\ActionRefuse;

class Task
{
    private const STATUS_NEW = 'statusNew';
    private const STATUS_CANCELED = 'statusCanceled';
    private const STATUS_IN_WORK = 'statusInWork';
    private const STATUS_PERFORMED = 'statusPerformed';
    private const STATUS_FAILED = 'statusFailed';
    private const ACTION_CANCEL = 'actionCancel';
    private const ACTION_RESPOND = 'actionRespond';
    private const ACTION_EXECUTE = 'actionExecute';
    private const ACTION_REFUSE = 'actionRefuse';

    private string $currentStatus = self::STATUS_NEW;

    public function __construct(
        private readonly int $customerId,
        private ?int $executorId = null
    ) {
    }

    /**
     * Объект класса создаёт заказчик, исполнитель, скорее всего, подключится позже
     * Функция установки id исполнителя задания
     * @param int $executorId - id исполнителя задания
     * 
     * @return int - id исполнителя задания
     */
    public function setExecutorId(int $executorId): self
    {
        $this->executorId = $executorId;

        return $this;
    }

    /**
     * Функция возвращения текущего статуса задания
     * 
     * @return string - текущий статус задания
     */
    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    /**
     * Функция возвращения "карты" статусов задания
     * 
     * @return array - массив со статусами заданий
     */
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

    /**
     * Функция возвращения "карты" действий с заданиями
     * 
     * @return array - массив со статусами заданий
     */
    public function getActionMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_EXECUTE => 'Завершено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    /**
     * Функция возвращения  статуса, в которой перейдёт задание после выполнения указанного действия
     * @param string $action - применяемое к заданию действие
     * 
     * @return string|null - следующй статус задания либо null
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            self::ACTION_CANCEL => self::STATUS_CANCELED,
            self::ACTION_RESPOND => self::STATUS_IN_WORK,
            self::ACTION_EXECUTE => self::STATUS_PERFORMED,
            self::ACTION_REFUSE => self::STATUS_FAILED,
        ];

        return $map[$action] ?? null;
    }

    /**
     * Функция возвращения доступных действий для задания в зависимости от каегории актора
     * @param int $id - id пользователя
     * 
     * @return object|null - доступное пользователю действие с заданием или null
     */
    public function getAvailableActions(int $id): ?object
    {
        if ($id !== $this->customerId && $id !== $this->executorId) {
            return null;
        }

        if ($this->currentStatus === self::STATUS_NEW && ActionCancel::checkRights($id, $this->customerId)) return new ActionCancel();
        if ($this->currentStatus === self::STATUS_NEW && ActionRespond::checkRights($id, $this->customerId, $this->executorId)) return new ActionRespond();
        if ($this->currentStatus === self::STATUS_IN_WORK && ActionExecute::checkRights($id, $this->customerId, $this->executorId)) return new ActionExecute();
        if ($this->currentStatus === self::STATUS_IN_WORK && ActionRefuse::checkRights($id, $this->customerId, $this->executorId)) return new ActionRefuse();
    }

    /**
     * Функция для тестового сценария проверки класса
     * @param string $action - применяемое к заданию действие
     * 
     */
    public function setCurrentStatusByAction(string $action): void
    {
        if (!isset($this->getActionMap()[$action])) {
            throw new Exception("Action {$action} is invalid");
        }
        $this->currentStatus = $this->getNextStatus($action);
    }
}
