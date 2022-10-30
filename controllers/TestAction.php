<?php

namespace app\controllers;

use yii\base\Action;

class TestAction extends Action
{
    public function run()
    {
        phpinfo();
    }
}