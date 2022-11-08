<?php

/** @var yii\web\View $this
 * @var Task[] $tasks
 */

use yii\helpers\Url;
use app\widgets\TasksWidget;
use app\widgets\ActiveMenuWidget;
use app\models\User;
use app\controllers\MyTasksController;
?>

<main class="container main-content">
    <div class="left-menu">
        <h3 class="head-main head-task">Мои задания</h3>
        <ul class="side-menu-list">
            <li class="side-menu-item <?= ActiveMenuWidget::widget(['links' => [Url::to('/my-tasks/index')], 'active' =>  'side-menu-item--active']) ?>">
                <a href="<?= Url::to('my-tasks/index') ?>" class="link link--nav"><?= Yii::$app->user->can(User::ROLE_CUSTOMER) ? MyTasksController::NEW_TASKS : MyTasksController::IN_WORK_TASKS ?></a>
            </li>
            <li class="side-menu-item <?= ActiveMenuWidget::widget(['links' => [Url::to('/my-tasks/work')], 'active' =>  'side-menu-item--active']) ?>">
                <a href="<?= Url::to('my-tasks/work') ?>" class="link link--nav"><?= Yii::$app->user->can(User::ROLE_CUSTOMER) ? MyTasksController::IN_WORK_TASKS : MyTasksController::OVERDUE_TASKS ?></a>
            </li>
            <li class="side-menu-item <?= ActiveMenuWidget::widget(['links' => [Url::to('/my-tasks/closed')], 'active' =>  'side-menu-item--active']) ?>">
                <a href="<?= Url::to('my-tasks/closed') ?>" class="link link--nav"><?= MyTasksController::CLOSED_TASKS ?></a>
            </li>
        </ul>
    </div>
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular">Новые задания</h3>
        <?= TasksWidget::widget(['dataProvider' => $dataProvider]) ?>
    </div>
</main>