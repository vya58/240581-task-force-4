<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="task-card">
    <div class="header-task">
        <?= Html::a(Html::encode($model->task_name), Url::to(['tasks/view', 'id' => $model->task_id]), ['class' => 'link link--block link--big']); ?>
        <p class="price price--task"><?= Html::encode($model->task_budget) ?> ₽</p>
    </div>
    <p class="info-text">
        <span class="current-time">
            <?= Yii::$app->formatter->asRelativeTime($model->task_date_create) ?>
        </span>
    </p>
    <p class="task-text"><?= Html::encode($model->task_essence) ?></p>
    <div class="footer-task">
        <p class="info-text town-text">
            <?= Html::encode($model->task_details) ?>
        </p>
        <p class="info-text category-text">
            <?= Html::encode($model->category->category_name) ?>
        </p>
        <?= Html::a('Смотреть Задание', Url::to(['tasks/view', 'id' => $model->task_id]), ['class' => 'button button--black']); ?>
    </div>
</div>