<?php

namespace app\controllers;

use yii;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    return $this->redirect(['login/index']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ]
        ];
    }
}
