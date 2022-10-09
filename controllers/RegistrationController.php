<?php

namespace app\controllers;

use Yii;
use app\models\forms\RegistrationForm;
use TaskForce\exceptions\DataSaveException;
use yii\filters\AccessControl;

class RegistrationController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());
            
            if ($registrationForm->validate()) {
                $registrationForm->createExecutor();
                return $this->goHome();
            }
            
        }
        return $this->render(
            'index',
            [
                'registerForm' => $registrationForm,
            ]
        );
    }
}