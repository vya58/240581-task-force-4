<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use \yii\helpers\Url;
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

        echo Html::tag('div', '', ['id' => 'map', 'class' => 'username', 'style' => 'width: 725px; height: 346px', 'data-latitude' => Html::encode($this->task->task_latitude), 'data-longitude' => Html::encode($this->task->task_longitude)]);

        echo Html::tag('p', Html::encode($location['city']), ['class' => 'map-address town']);

        echo Html::tag('p', Html::encode($location['adress']), ['class' => 'map-address']);
    }
}
