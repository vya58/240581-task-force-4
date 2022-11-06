<?php

/** @var yii\web\View $this
 * @var Task[] $tasks
 */

use yii\widgets\ActiveForm;
use \yii\helpers\Url;
use app\widgets\UserProfileMenuWidget;

/** @var yii\web\View $this */
/** @var SecuritySettingsForm $registrationForm */

?>

<main class="main-content main-content--left container">
    <div class="left-menu left-menu--edit">
        <?= UserProfileMenuWidget::widget() ?>
    </div>
    <div class="my-profile-form">
        <?php $form = ActiveForm::begin([
            'id' => 'password-form',
            'method' => 'post',
        ]); ?>
        <h3 class="head-main head-task">Настройки безопасности</h3>
        <?= $form->field($securitySettingsForm, 'currentPassword', ['options' => ['class' => 'half-wrapper form-group control-label']])->passwordInput() ?>
        <?= $form->field($securitySettingsForm, 'newPassword', ['options' => ['class' => 'half-wrapper form-group control-label']])->passwordInput() ?>
        <?= $form->field($securitySettingsForm, 'newPasswordRepeat', ['options' => ['class' => 'half-wrapper form-group control-label']])->passwordInput() ?>
        <?= $form->field($securitySettingsForm, 'showContacts', ['options' => ['class' => 'form-group']])->checkbox(['class' => 'control-label checkbox-label']) ?>

        <input type="submit" class="button button--blue" value="Сохранить">
        <?php ActiveForm::end(); ?>
    </div>
</main>