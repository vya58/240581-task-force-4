<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use \yii\helpers\Url;

/**
 * Отображает кнопки принятия-отклонения отзывов
 *
 */
class ButtonPopupWidget extends Widget
{
    public $response;

    public function run()
    {
        echo Html::a('Принять', Url::to(['tasks/accept', 'respond_id' => $this->response->respond_id]), ['class' => "button button--blue button--small"]);
        
        echo Html::a('Отказать', Url::to(['tasks/reject', 'respond_id' => $this->response->respond_id]), ['class' => "button button--orange button--small"]);
    }
}
