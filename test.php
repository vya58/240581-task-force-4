<?php
// Тестовый сценарий для задания "1.20. Камень судьбы"

// Подключение класса "Task"
require_once 'classes/Task.php';

// Создание объектов класса "Task"
$task1 = new Task(1, 2);
$task2 = new Task(1);

// "Добавился" исполнитель
$task2->setExecutorId(2);

// Вызов и проверка метода возврата «карты» статусов и действий
echo 'Массив с «картой» статусов и действий:' . '<br>' . '<br>';
$tasks1 = $task1->getStatusMap();
$tasks2 = $task2->getStatusMap();
var_dump($tasks1);

echo '<br>' . '<br>';

// Вызов и проверка метода получения статуса, в которой он перейдёт после выполнения указанного действия
echo assert($task1->getNextStatus('actionCancel') === array_search('Отменено', $task1->getStatusMap()), 'Проверьте: action_cancel -> status_canceled') . '<br>';
echo assert($task1->getNextStatus('actionRespond') === array_search('В работе', $task1->getStatusMap()), 'Проверьте: action_respond -> status_in_work') . '<br>';
echo assert($task1->getNextStatus('actionExecute') === array_search('Выполнено', $task1->getStatusMap()), 'Проверьте: action_execute -> status_performed') . '<br>';
echo assert($task1->getNextStatus('actionRefuse') === array_search('Провалено', $task1->getStatusMap()), 'Проверьте: action_refuse -> status_failed') . '<br>';

// Вызов и проверка метода получения доступных действий для указанного статуса:
// Статус задания - "Новое", возможное действие заказчика: "Отменить", переход в статус "Отменено"
$action2 = $task2->getAvailableActions(1);
$task_status2 = $task2->getNextStatus($action2);
echo  '<br>' . 'Новый статус задания: ' . $tasks2[$task_status2] . '<br>';

// Статус задания - "Новое", возможное действие исполнителя: "Откликнуться", переход в статус "В работе"
$action2 = $task2->getAvailableActions(2);
$task_status2 = $task2->getNextStatus($action2);
echo 'Новый статус задания: ' . $tasks2[$task_status2] . '<br>';

// Статус задания - "В работе", возможное действие заказчика: "Завершено", переход в статус "Выполнено"
$task2-> setCurrentStatusByAction('actionRespond');
$action2 = $task2->getAvailableActions(1);
$task_status2 = $task2->getNextStatus($action2);
echo 'Новый статус задания: ' . $tasks2[$task_status2] . '<br>';

// Статус задания - "В работе", возможное действие исполнителя: "Отказаться", переход в статус "Провалено"
$task2-> setCurrentStatusByAction('actionRespond');
$action2 = $task2->getAvailableActions(2);
$task_status2 = $task2->getNextStatus($action2);
echo 'Новый статус задания: ' . $tasks2[$task_status2];
