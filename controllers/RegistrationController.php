<?php

namespace app\controllers;

use Yii;
use app\components\AccessControllers\AnonymousController;
use app\models\forms\RegistrationForm;
use TaskForce\exceptions\DataSaveException;

class RegistrationController extends AnonymousController
{
    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());
            if ($registrationForm->validate()) {
                if (!$registrationForm->loadToUser()->save()) {
                    throw new DataSaveException('Не удалось сохранить данные');
                }
                Yii::$app->response->redirect(['task']);
            }
        }
        return $this->render('registration', ['model' => $registrationForm]);
    }
}