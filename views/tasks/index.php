<?php

/** @var yii\web\View $this
 * @var Task[] $tasks
 */

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\forms\TaskfilterForm;

$this->title = 'Новое'; ?>
<main class="container main-content">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?php if (count($tasks)) : ?>
            <?php foreach ($tasks as $task) : ?>
                <?php $category = $task->category; ?>
                <div class="task-card">
                    <div class="header-task">
                        <?= Html::a(Html::encode($task->task_name), Url::to(['tasks/view', 'id' => $task->task_id]), ['class' => "link link--block link--big"]); ?>
                        <p class="price price--task"><?= Html::encode($task->task_budget) ?> ₽</p>
                    </div>
                    <p class="info-text">
                        <span class="current-time">
                            <?= Yii::$app->formatter->asRelativeTime($task->task_date_create) ?>
                        </span>
                    </p>
                    <p class="task-text">
                        <?= Html::encode($task->task_essence) ?>
                    </p>
                    <div class="footer-task">
                        <p class="info-text town-text">
                            <?= Html::encode($task->task_details) ?>
                        </p>
                        <p class="info-text category-text">
                            <?= Html::encode($category->category_name) ?>
                        </p>
                        <a href="<?= Url::to(
                                        ['tasks/view', 'id' => $task->task_id]
                                    ) ?>" class="button button--black">Смотреть Задание</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pagination-wrapper">
                <ul class="pagination-list">
                    <li class="pagination-item mark">
                        <!-- Добавить ссылку -->
                        <a href="#" class="link link--page"></a>
                    </li>
                    <li class="pagination-item">
                        <!-- Добавить ссылку -->
                        <a href="#" class="link link--page">1</a>
                    </li>
                    <li class="pagination-item pagination-item--active">
                        <!-- Добавить ссылку -->
                        <a href="#" class="link link--page">2</a>
                    </li>
                    <li class="pagination-item">
                        <!-- Добавить ссылку -->
                        <a href="#" class="link link--page">3</a>
                    </li>
                    <li class="pagination-item mark">
                        <!-- Добавить ссылку -->
                        <a href="#" class="link link--page"></a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['tasks/index'],
                ]); ?>

                <h4 class="head-card">Категории</h4>
                <?= $form->field($tasksFilter, 'categories', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkboxList($categories, ['class' => 'checkbox-wrapper', 'itemOptions' => ['labelOptions' => ['class' => 'control-label']]]) ?>

                <h4 class="head-card">Дополнительно</h4>
                <?= $form->field($tasksFilter, 'distantWork', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkbox(['labelOptions' => ['class' => 'control-label']]) ?>

                <?= $form->field($tasksFilter, 'noResponse', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkbox(['labelOptions' => ['class' => 'control-label']]) ?>

                <h4 class="head-card">Период</h4>
                <?= $form->field($tasksFilter, 'period', ['template' => '{input}', 'options' => ['class' => 'form-group']])->dropDownList(TaskFilterForm::TASK_PERIOD) ?>

                <?= Html::tag('input', 'Искать', ['type' => 'submit', 'class' => ['button', 'button--blue'], 'value' => 'Искать']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</main>