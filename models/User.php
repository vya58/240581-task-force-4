<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Task;

/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string $date_add
 * @property int|null $city_id
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $personal_information
 * @property int|null $rating
 * @property string|null $status
 * @property string|null $birthday
 * @property string $role
 *
 * @property Category[] $categories
 * @property City $city
 * @property Respond[] $responds
 * @property Task[] $customerTasks
 * @property Task[] $executorTasks
 * @property Task[] $respondedTasks
 * @property UserCategory[] $userCategories
 * @property int TasksCount $tasksCount
 * @property int FailTasksCount $failTasksCount
 * @property int SumGrade $sumGrade
 * @property int AverageGrade $averageGrade
 * @property int Rating $rating
 */
class User extends \yii\db\ActiveRecord
{
    // Статусы исполнителя
    public const STATUS_FREE = 'free';
    public const STATUS_BUSY = 'busy';

    public const ROLE_CUCTOMER = 'customer';
    public const ROLE_EXECUTOR = 'executor';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'user_role'], 'required'],
            [['date_add', 'birthday'], 'safe'],
            [['city_id', 'rating'], 'integer'],
            [['personal_information'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['email', 'password', 'avatar'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['telegram'], 'string', 'max' => 64],
            [['status'], 'string', 'max' => 10],
            [['user_role'], 'string', 'max' => 45],
            [['email'], 'unique'],
            [['avatar'], 'unique'],
            [['phone'], 'unique'],
            [['telegram'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользователя',
            'name' => 'Имя пользователя',
            'email' => 'Email пользователя',
            'password' => 'Пароль пользователя',
            'avatar' => 'Аватар пользователя',
            'date_add' => 'Дата регитрации пользователя',
            'city_id' => 'ID города',
            'executor_phone' => 'Телефон исполнителя',
            'executor_telegram' => 'Telegram исполнителя',
            'personal_information' => 'Персональная информация',
            'executor_rating' => 'Рейтинг исполнителя',
            'executor_status' => 'Статус исполнителя',
            'executor_birthday' => 'День рождения исполнителя',
            'user_role' => 'Роль пльзователя',
        ];
    }

    /**
     * Функция возвращения "карты" статусов исполнителя
     * 
     * @return array - массив со статусами исполнителя
     */
    public static function getExecutorStatusMap(): array
    {
        return [
            self::STATUS_FREE => 'Открыт для новых заказов',
            self::STATUS_BUSY => 'Занят',
        ];
    }

    /**
     * Функция возвращения "карты" статусов исполнителя
     * 
     * @return array - массив со статусами исполнителя
     */
    public static function getUserRoleMap(): array
    {
        return [
            self::ROLE_CUCTOMER => 'Заказчик',
            self::ROLE_EXECUTOR => 'Исполнитель',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['category_id' => 'category_id'])->viaTable('user_category', ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::class, ['executor_id' => 'user_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'user_id']);
    }

    /**
     * Gets query for [[executorTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(Task::class, ['executor_id' => 'user_id']);
    }

    /**
     * Gets query for [[Tasks1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespondedTasks()
    {
        return $this->hasMany(Task::class, ['task_id' => 'task_id'])->viaTable('respond', ['executor_id' => 'user_id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::class, ['user_id' => 'user_id']);
    }

    public function getExecutorTasksCount(): int
    {
        return $this->getExecutorTasks()->count();
    }

    public function getFailTasksCount(): int
    {
        return $this->getExecutorTasks()->where(['task_status' => Task::STATUS_FAILED])->count();
    }

    public function getSumGrade(): ?int
    {
        return $this->getExecutorTasks()->sum('grade');
    }

    public function getCountGrade(): int
    {
        return $this->getExecutorTasks()->where(['not in', 'grade', [null]])->count();
    }

    public function getAverageGrade()
    {
        return $this->getExecutorTasks()
            ->where(['IN', 'task_status', [Task::STATUS_PERFORMED, Task::STATUS_FAILED]])
            ->average('grade');
    }

    public function getRating(): ?int
    {
        $data = User::find()
            ->alias('u')
            ->leftJoin(Task::tableName() . ' t', 't.executor_id = u.user_id')
            ->where(['IN', 't.task_status', [Task::STATUS_PERFORMED, Task::STATUS_FAILED]])
            ->groupby(['u.user_id'])
            ->having(new Expression('AVG(t.grade) >= :grade', [':grade' => $this->getAverageGrade()]))
            ->orderBy(['AVG(t.grade)' => SORT_DESC])
            ->all();

        for ($i = count($data) - 1; $i >= 0; $i--) {
            if ($data[$i]->user_id === $this->user_id) {

                return $i + 1;
            }
        }
        return null;
    }
}
