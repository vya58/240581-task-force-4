<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\User;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser()
    {
        if (null === $this->_user) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
