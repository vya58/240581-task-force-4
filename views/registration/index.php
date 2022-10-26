<?php

/** @var yii\web\View $this
 * @var Task[] $tasks
 */

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\forms\RegistrationForm;
use app\models\City;

$this->title = 'Регистрация';

/** @var yii\web\View $this */
/** @var RegistrationForm $registrationForm */
?>

<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'method' => 'post',
            ]); ?>
            <h3 class="head-main head-task">Регистрация нового пользователя</h3>
            <?= $form->field($registrationForm, 'name', ['options' => ['class' => 'form-group']]) ?>
            <div class="half-wrapper">
                <?= $form->field($registrationForm, 'email', ['options' => ['class' => ' form-group']]) ?>
                <?= $form->field($registrationForm, 'city', ['options' => ['class' => 'form-group control-label']])->dropDownList(ArrayHelper::map(City::find()->all(), 'city_id', 'city_name'), ['class' => 'form-group checkbox-wrapper control-label']) ?>
            </div>
            <?= $form->field($registrationForm, 'password', ['options' => ['class' => 'half-wrapper form-group control-label']])->passwordInput() ?>
            <?= $form->field($registrationForm, 'passwordRepeat', ['options' => ['class' => 'half-wrapper form-group control-label']])->passwordInput() ?>
            <?= $form->field($registrationForm, 'isExecutor', ['options' => ['class' => 'form-group']])->checkbox(['class' => 'control-label checkbox-label']) ?>

            <input type="submit" class="button button--blue" value="Создать аккаунт">
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>