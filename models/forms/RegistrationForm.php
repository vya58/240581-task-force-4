<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\City;
use app\models\Executor;
use app\models\User;
use DateTime;

class RegistrationForm extends Model
{
    public string $name;
    public string $email;
    public string $city;
    public string $password;
    public string $passwordRepeat;
    public bool $isExecutor = false;

    public function rules(): array
    {
        return [
            [['name', 'email', 'city', 'password', 'passwordRepeat', 'isExecutor'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['password', 'passwordRepeat'], 'string', 'min' => 6, 'max' => 64],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => Executor::class, 'targetAttribute' => ['email' => 'executor_email'], 'message' => 'Пользователь с таким e-mail уже существует'],
            [['isExecutor'], 'boolean'],
            [['city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city' => 'city_id']],
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

    public function loadToUser()
    {
        $user = new User;
        $user->email = $this->email;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->login = $this->login;
        $user->city_id = $this->cityId;

        return $user;
    }

    public function createExecutor()
    {
        $executor = new Executor();
        $executor->executor_name = $this->name;
        $executor->executor_email = $this->email;
        $executor->city_id = $this->city;
        $executor->executor_password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $executor->executor_date_add = Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');

        $executor->save();
    }
}
