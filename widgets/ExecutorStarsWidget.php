<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

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
