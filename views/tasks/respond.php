<?php

use yii\widgets\ActiveForm;
use app\models\forms\RespondForm;

/** @var yii\web\View $this */
/** @var RespondForm $model */
/** @var ActiveForm $form */
?>

<section class="pop-up pop-up--act_response pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Добавление отклика к заданию</h4>
        <p class="pop-up-text">
            Вы собираетесь оставить свой отклик к этому заданию.
            Пожалуйста, укажите стоимость работы и добавьте комментарий, если необходимо.
        </p>
        <div class="addition-form pop-up--form regular-form">
            <?php
            $form = ActiveForm::begin([
                'id' => 'response-form',
                'method' => 'post',
                'action' => ['tasks/respond'],
            ]); ?>
            <?= $form->field($responseForm, 'offerMessage')->textarea(['labelOptions' => ['class' => 'control-label']]) ?>
            <?= $form->field($responseForm, 'challengerPrice')->input('number', ['labelOptions' => ['class' => 'control-label']]) ?>
            <?= $form->field($responseForm, 'taskId', ['template' => '{input}'])->hiddenInput(['value' => $task->task_id])->label(false) ?>
            <input type="submit" class="button button--pop-up button--blue" value="Принять">
            <?php ActiveForm::end() ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>