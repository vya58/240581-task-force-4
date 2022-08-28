<?php
// Тестовый сценарий для задания "1.20. Камень судьбы"

use TaskForce\models\Task;
use TaskForce\exceptions\TaskException;

// Создание объекта класса "Task"
$task1 = new Task(1, 2);

$tagDoubleBr = '<br>' . '<br>';

// Вызов и проверка метода возврата «карты» статусов и действий
echo '<strong>' . 'Массив с «картой» статусов и действий:' . '</strong>' . $tagDoubleBr;
$tasks1 = $task1->getStatusMap();
var_dump($tasks1);

echo $tagDoubleBr . '<strong>' . '1) Вызов и проверка с помощью assert метода получения статуса getAvailableActions(), в которой он перейдёт после выполнения указанного действия:' . '</strong>' . $tagDoubleBr;

echo "Исходный статус задачи- 'Новый', действие - 'Отменить', новый статус задачи - 'Отменено': результат - ";
echo assert($task1->getNextStatus('actionCancel') === array_search('Отменено', $task1->getStatusMap()), 'Проверьте: action_cancel -> status_canceled') . '<br>';

echo "Исходный статус задачи - 'Новый', действие - 'Откликнуться', новый статус задачи - 'В работе': результат - ";
echo assert($task1->getNextStatus('actionRespond') === array_search('В работе', $task1->getStatusMap()), 'Проверьте: action_respond -> status_in_work') . '<br>';

echo "Исходный статус задачи - 'В работе', действие - 'Завершено', новый статус задачи - 'Выполнено': результат - ";
echo assert($task1->getNextStatus('actionExecute') === array_search('Выполнено', $task1->getStatusMap()), 'Проверьте: action_execute -> status_performed') . '<br>';

echo "Исходный статус задачи - 'В работе', действие - 'Отказаться', новый статус задачи - 'Провалено': результат - ";
echo assert($task1->getNextStatus('actionRefuse') === array_search('Провалено', $task1->getStatusMap()), 'Проверьте: action_refuse -> status_failed') . $tagDoubleBr;

/**
 * Функция проверки и отображения текущего статуса задания
 * @param array $tasks - массив со статусами заданий
 * @param object $task - объект класса Task
 * 
 * @return string - текущий статус задания
 */
function outputCurrentTaskStatus(array $tasks, object $task): string
{
    echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
    $taskStatus = $task->getCurrentStatus();
    echo  "Статус задания: '{$tasks[$taskStatus]}'" . '<br>' . '<br>';
    return $taskStatus;
}

/**
 * Функция проверки, что действия возвращаются в виде объекта
 * @param mixed $actionTask - результат метода getAvailableActions() объекта класса Task
 * 
 */
function chekObjectAvailableReturn($actionTask)
{
    echo 'Проверка, что возвращаются те же действия, что и раньше,но были в виде строк, а теперь объектами:' . '<br>';
    var_dump($actionTask);
    echo '<br>' . '<br>';
}

/**
 * Функция отображения текущего статуса задания
 * @param array $tasks - массив со статусами заданий
 * @param object $task - объект класса Task
 * @param object $actionTask - объект действия с задачей объекта класса Task
 * @param string|null $taskStatus - следующий статус задачи объекта класса Task
 * 
 */
function outputNewTaskStatus(array $tasks, object $task, object $actionTask): void
{
    try {
        $taskStatus = $task->getNextStatus($actionTask->getInternalName());
        echo "Новый статус задания: '{$tasks[$taskStatus]}'" . '<br>' . '<br>';
    } catch (TaskException $e) {
        echo $e;
    }
}

/**
 * Функция создания сообщения в цикле проверки заданий
 * @param object $task - объект класса Task
 * @param int $userId - id пользователя, чьё действие проверяется
 * @param int $customerId - id заказчика задания
 * 
 * @return string - выводимое сообщение
 */
function createMessage(object $task, int $userId, int $customerId): string
{
    $taskStatus = $task->getStatusMap()[$task->getCurrentStatus()];
    try {
        $actionTask2 = $task->getAvailableActions($userId);
    } catch (TaskException) {
        return '<strong>' . "- Попытка действия с заданием со статусом '{$taskStatus}' пользователя с id, не соответствующим заказчику и исполнителю задания:" . '</strong>' . '<br>' . '<br>';
    }

    $actionName = $actionTask2->getActionName();
    $userStatus = 'заказчика';

    if ($customerId !== $userId) {
        $userStatus = 'исполнителя';
    }

    return '<strong>' . "- Исходный статус задания - '{$task->getStatusMap()[$task->getCurrentStatus()]}', действие {$userStatus} - '{$actionName}':" . '</strong>' . '<br>' . '<br>';
}

/**
 * Функция тестирования объекта класса Task по вызову и проверке метода получения доступных действий для указанного статуса getAvailableActions()
 * @param object $task - объект класса Task
 * @param array $usersId - id пользователя, чьё действие проверяется
 * 
 * @return string - выводимое сообщение
 */
function testObjectTask(object $task, array $usersId, int $customerId): void
{
    foreach ($usersId as $value) {
        echo createMessage($task, $value, $customerId);
        $tasks = $task->getStatusMap();
        outputCurrentTaskStatus($tasks, $task);

        try {
            $actionTask = $task->getAvailableActions($value);
            chekObjectAvailableReturn($actionTask);
            outputNewTaskStatus($tasks, $task, $actionTask);
        } catch (TaskException $e) {
            echo $e . '<br>' . '<br>';
            outputCurrentTaskStatus($tasks, $task);
        }
    }
}

echo '<strong>' . '2) Вызов и проверка метода получения доступных действий для указанного статуса getAvailableActions().' . '</strong>' .  $tagDoubleBr;

$usersId = [1, 2, 3];
$customerId = $usersId[0];
$executorId = $usersId[1];

$task2 = new Task($customerId);

$taskStatus = $task2->getCurrentStatus();
$tasks2 = $task2->getStatusMap();

// "Добавился" исполнитель в задачу 2
$task2->setExecutorId($executorId);

// Проверка задания со статусом 'Новое'
testObjectTask($task2, $usersId, $customerId);

// Проверка задания со статусом 'В работе'
try {
    $task2->setCurrentStatusByAction('actionRespond');
    testObjectTask($task2, $usersId, $customerId);
} catch (TaskException $e) {
    echo $e;
}
