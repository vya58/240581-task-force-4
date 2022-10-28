<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Отрисовывает оценку исполнителю в звёздах
 *
 * @return string - Возвращает кнопку с параметрами, заданными в объекте.
 */
class ExecutorStarsWidget extends Widget
{
    public $rating;
    const MAX_COUNT_STARS = 5;

    public function run(): string
    {
        $result = '';
        for ($i = 0; $i < self::MAX_COUNT_STARS; $i++) {
            $result .= Html::tag('span', '&nbsp;',['class' => $this->rating > $i ? 'fill-star' : '']);
        }
        return $result;
    }
}
