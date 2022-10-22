<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\City;
use app\models\User;

class RegistrationForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $city = '';
    public string $password = '';
    public string $passwordRepeat = '';
    public bool $isExecutor = false;

    public function rules(): array
    {
        return [
            [['name', 'email', 'password', 'passwordRepeat', 'isExecutor', 'city'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 64],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email'], 'message' => 'Пользователь с таким e-mail уже существует'],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city' => 'city_id']],
            [['isExecutor'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повтор пароля',
            'isExecutor' => 'Я собираюсь откликаться на заказы',
            'city' => 'Ваш город',
        ];
    }

    public function createUser(): bool
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->user_role = $this->isExecutor ? User::ROLE_EXECUTOR : User::ROLE_CUSTOMER;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->city_id = $this->city;

        return $user->save();
    }
}
