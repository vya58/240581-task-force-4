<?php
// Тестовый сценарий для задания "1.20. Камень судьбы"

// Подключение класса "Task"
require_once 'classes/Task.php';

// Создание объекта класса "Task"
$task = new Task(1);

// "Добавился" исполнитель
$task->setExecutorId(2);

// Вызов и проверка метода возврата «карты» статусов и действий
echo 'Массив с «картой» статусов и действий:' . '<br>' . '<br>';
$tasks = $task->getStatusMap();
var_dump($tasks);

echo '<br>' . '<br>';

// Вызов и проверка метода получения статуса, в которой он перейдёт после выполнения указанного действия
echo assert($task->getNextStatus('action_cancel') === Task::STATUS_CANCELED, 'Проверьте: action_cancel -> status_canceled') . '<br>';
echo assert($task->getNextStatus('action_respond') === Task::STATUS_IN_WORK, 'Проверьте: action_respond -> status_in_work') . '<br>';
echo assert($task->getNextStatus('action_execute') === Task::STATUS_PERFORMED, 'Проверьте: action_execute -> status_performed') . '<br>';
echo assert($task->getNextStatus('action_refuse') === Task::STATUS_FAILED, 'Проверьте: action_refuse -> status_failed') . '<br>';

// Вызов и проверка метода получения доступных действий для указанного статуса:
// Статус задания - "Новое", возможное действие заказчика: "Отменить", переход в статус "Отменено"
$task->setCurrentStatus();
$action = $task->getAvailableActions(1);
$task_status = $task->getNextStatus($action);

echo  '<br>' . 'Новый статус задания: ' . $tasks[$task_status] . '<br>';

// Статус задания - "Новое", возможное действие исполнителя: "Откликнуться", переход в статус "В работе"
$action = $task->getAvailableActions(2);
$task_status = $task->getNextStatus($action);
echo 'Новый статус задания: ' . $tasks[$task_status] . '<br>';

// Статус задания - "В работе", возможное действие заказчика: "Завершено", переход в статус "Выполнено"
$task->setCurrentStatus('action_respond');
$action = $task->getAvailableActions(1);
$task_status = $task->getNextStatus($action);
echo 'Новый статус задания: ' . $tasks[$task_status] . '<br>';

// Статус задания - "В работе", возможное действие исполнителя: "Отказаться", переход в статус "Провалено"
$task->setCurrentStatus('action_respond');
$action = $task->getAvailableActions(2);
$task_status = $task->getNextStatus($action);
echo 'Новый статус задания: ' . $tasks[$task_status];
