<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Отображает кнопки принятия-отклонения отзывов
 *
 */
class UserProfileMenuWidget extends Widget
{
    public $response;

    public function run()
    {
        return $this->render('userProfileMenuWidget');
    }
}
