<?php

namespace app\widgets;

use yii\base\Widget;
use \yii\helpers\Url;

/**
 * Добавляет класс к ссылкам меню
 * @param string $link - ссылка текущего меню 
 * @param string $active - класс CSS, который нужно добавить, чтобы сделать ссылку активной
 * 
 * @return string $active - класс CSS, делающий ссылку активной
 *
 */
class ActiveMenuWidget extends Widget
{
    public $links;
    public $active;

    public function run()
    {
        $active = '';

        $path = parse_url(Url::to(''), PHP_URL_PATH);

        foreach ($this->links as $link) {
            if ($path === $link) {
                $active .= $this->active;
            }
        }
        return $active;
    }
}
