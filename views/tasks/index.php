<?php

/** @var yii\web\View $this
 * @var Task[] $tasks
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\TasksWidget;
use app\models\forms\TaskfilterForm;

?>

<main class="container main-content">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <?= TasksWidget::widget(['dataProvider' => $dataProvider]) ?>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['tasks/index'],
                ]); ?>

                <h4 class="head-card">Категории</h4>
                <?= $form->field($model, 'categories', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkboxList($categories, ['class' => 'checkbox-wrapper', 'itemOptions' => ['labelOptions' => ['class' => 'control-label']]]) ?>

                <h4 class="head-card">Дополнительно</h4>
                <?= $form->field($model, 'distantWork', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkbox(['labelOptions' => ['class' => 'control-label']]) ?>

                <?= $form->field($model, 'noResponse', ['template' => '{input}', 'options' => ['class' => 'form-group']])->checkbox(['labelOptions' => ['class' => 'control-label']]) ?>

                <h4 class="head-card">Период</h4>
                <?= $form->field($model, 'period', ['template' => '{input}', 'options' => ['class' => 'form-group']])->dropDownList(TaskFilterForm::TASK_PERIOD) ?>

                <?= Html::tag('input', 'Искать', ['type' => 'submit', 'class' => ['button', 'button--blue'], 'value' => 'Искать']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>