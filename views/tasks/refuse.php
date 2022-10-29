<?php

use yii\helpers\Html;
use \yii\helpers\Url;

?>

<section class="pop-up pop-up--refusal pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Отказ от задания</h4>
        <p class="pop-up-text">
            <b>Внимание!</b><br>
            Вы собираетесь отказаться от выполнения этого задания.<br>
            Это действие плохо скажется на вашем рейтинге и увеличит счетчик проваленных заданий.
        </p>
        <?= Html::a('Отказаться', Url::to(['tasks/refuse', 'id' => $task->task_id]), ['class' => "button button--pop-up button--orange"]) ?>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>