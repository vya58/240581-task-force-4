<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Отображает кнопки принятия-отклонения отзывов
 *
 */
class ButtonPopupWidget extends Widget
{
    public $response;

    public function run()
    {
        return $this->render('buttonPopup', ['response' => $this->response]);
    }
}
