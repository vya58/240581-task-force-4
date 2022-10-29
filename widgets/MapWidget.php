<?php

namespace app\widgets;

use yii\base\Widget;
use app\models\helpers\GeocoderHelper;

/**
 * Отображает кнопки принятия-отклонения отзывов
 *
 */
class MapWidget extends Widget
{
    public $task;

    public function run()
    {
        $location = GeocoderHelper::getAdress($this->task->task_longitude, $this->task->task_latitude);

        return $this->render('yandexMap', ['task' => $this->task, 'location' => $location]);
    }
}
