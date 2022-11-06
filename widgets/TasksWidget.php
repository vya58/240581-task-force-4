<?php

namespace app\widgets;

use yii\base\Widget;

/**
 * Отображает кнопки принятия-отклонения отзывов
 *
 */
class TasksWidget extends Widget
{
    public $dataProvider;

    public function run()
    {
        return $this->render('tasks', ['dataProvider' => $this->dataProvider]);
    }
}
