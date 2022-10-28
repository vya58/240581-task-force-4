<?php

use yii\widgets\ActiveForm;

?>
<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin([
                'id' => 'complete-form',
                'method' => 'post',
                'action' => ['tasks/complete'],
            ]); ?>
            <?= $form->field($completeForm, 'review')->textarea(['labelOptions' => ['class' => 'control-label']]) ?>
            <?= $form->field($completeForm, 'grade', ['template' => '{input}'])->hiddenInput()->label(false) ?>
            <?= $form->field($completeForm, 'taskId', ['template' => '{input}'])->hiddenInput(['value' => $task->task_id])->label(false) ?>
            <p class="completion-head control-label">Оценка работы</p>
            <div class="stars-rating big active-stars">
                <span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span>
            </div>
            <input type="submit" class="button button--pop-up button--blue" value="Завершить">
            <?php ActiveForm::end() ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>