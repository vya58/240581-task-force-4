<?php
// Тестовый сценарий для задания "1.20. Камень судьбы"

use TaskForce\models\Task;

// Создание объектов класса "Task"
$task1 = new Task(1, 2);
$task2 = new Task(1);

// Вызов и проверка метода возврата «карты» статусов и действий
echo '<strong>' . 'Массив с «картой» статусов и действий:' . '</strong>' . '<br>' . '<br>';
$tasks1 = $task1->getStatusMap();
$tasks2 = $task2->getStatusMap();
$tasks3 = $task2->getStatusMap();
var_dump($tasks1);

echo '<br>' . '<br>';

echo '<strong>' . '1) Вызов и проверка с помощью assert метода получения статуса getAvailableActions(), в которой он перейдёт после выполнения указанного действия:' . '</strong>' . '<br>' . '<br>';

echo "Исходный статус задачи- 'Новый', действие - 'Отменить', новый статус задачи - 'Отменено': результат - ";
echo assert($task1->getNextStatus('actionCancel') === array_search('Отменено', $task1->getStatusMap()), 'Проверьте: action_cancel -> status_canceled') . '<br>';

echo "Исходный статус задачи - 'Новый', действие - 'Откликнуться', новый статус задачи - 'В работе': результат - ";
echo assert($task1->getNextStatus('actionRespond') === array_search('В работе', $task1->getStatusMap()), 'Проверьте: action_respond -> status_in_work') . '<br>';

echo "Исходный статус задачи - 'В работе', действие - 'Завершено', новый статус задачи - 'Выполнено': результат - ";
echo assert($task1->getNextStatus('actionExecute') === array_search('Выполнено', $task1->getStatusMap()), 'Проверьте: action_execute -> status_performed') . '<br>';

echo "Исходный статус задачи - 'В работе', действие - 'Отказаться', новый статус задачи - 'Провалено': результат - ";
echo assert($task1->getNextStatus('actionRefuse') === array_search('Провалено', $task1->getStatusMap()), 'Проверьте: action_refuse -> status_failed') . '<br>' . '<br>';

echo '<strong>' . '2) Вызов и проверка метода получения доступных действий для указанного статуса getAvailableActions().' . '</strong>' .  '<br>' . '<br>';

echo '<strong>' . "2.1) Исходный статус задачи- 'Новый', действие заказчика - 'Отменить':" . '</strong>' . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(1);

echo 'Проверка, что возвращаются те же действия, что и раньше,но были в виде строк, а теперь объектами:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';

$taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
echo 'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

// "Добавился" исполнитель
$task2->setExecutorId(2);

echo '<strong>' . "2.2) Попытка действия с задачей со статусом 'Новая' пользователя с id, не соответствующим заказчику и исполнителю задания:" . '</strong>' . '<br>' . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(3);

echo 'Проверка, что возвращается null, т.е. нет доступных действий с этим заданием у данного пользователя:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';;

if (!$actionTask2) {
    echo 'Вам не доступны действия с этой задачей' . '<br>' . '<br>';
} else {
    $taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
    echo  'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';
}

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

echo "2.3) Исходный статус задачи- 'Новая', действие исполнителя - 'Откликнуться':" . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(2);

echo 'Проверка, что возвращаются те же действия, что и раньше,но были в виде строк, а теперь объектами:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';;

$taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
echo 'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$task2->setCurrentStatusByAction('actionRespond');
echo "2.4) Исходный статус задачи- 'В работе', действие исполнителя - 'Отказаться':" . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(2);

echo 'Проверка, что возвращаются те же действия, что и раньше,но были в виде строк, а теперь объектами:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';

$taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
echo 'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

echo "2.5) Исходный статус задачи- 'В работе', действие заказчика - 'Завершено':" . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(1);

echo 'Проверка, что возвращаются те же действия, что и раньше,но были в виде строк, а теперь объектами:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';

$taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
echo 'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

echo '<strong>' . "2.6) Попытка действия с задачей со статусом 'В работе' пользователя с id, не соответствующим заказчику и исполнителю задания:" . '</strong>' . '<br>' . '<br>';

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';

$actionTask2 = $task2->getAvailableActions(3);

echo 'Проверка, что возвращается null, т.е. нет доступных действий с этим заданием у данного пользователя:' . '<br>';
var_dump($actionTask2);
echo '<br>' . '<br>';;

if (!$actionTask2) {
    echo 'Вам не доступны действия с этой задачей' . '<br>' . '<br>';
} else {
    $taskStatus2 = $task2->getNextStatus($actionTask2->getInternalName());
    echo  'Новый статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';
}

echo '<strong>' . 'Проверка текущего статуса задания:' . '</strong>' . '<br>';
$taskStatus2 = $task2->getCurrentStatus();
echo  'Статус задания: ' . $tasks2[$taskStatus2] . '<br>' . '<br>';
