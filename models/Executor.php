<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Task;

/**
 * This is the model class for table "executor".
 *
 * @property int $executor_id
 * @property int|null $city_id
 * @property string $executor_name
 * @property string $executor_email
 * @property string $executor_password
 * @property string|null $executor_avatar
 * @property string $executor_date_add
 * @property string|null $executor_phone
 * @property string|null $executor_telegram
 * @property string|null $personal_information
 * @property int|null $count_tasks
 * @property float|null $executor_rating
 * @property int|null $executor_status
 * @property string|null $executor_birthday
 *
 * @property Category[] $categories
 * @property City $city
 * @property ExecutorCategory[] $executorCategories
 * @property Respond[] $responds
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property int TasksCount $tasksCount
 * @property int SumGrade $sumGrade
 * @property int CountGrade $countGrade
 * @property int|null Rating $rating
 */
class Executor extends ActiveRecord implements IdentityInterface
{
    public const STATUS_FREE = 'Free';
    public const STATUS_BUSY = 'Busy';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['executor_name', 'executor_email', 'executor_password', 'executor_date_add'], 'required'],
            [['executor_date_add', 'executor_birthday'], 'safe'],
            [['personal_information'], 'string'],
            [['executor_status'], 'string'],
            [['executor_rating'], 'number'],
            [['executor_name'], 'string', 'max' => 50],
            [['executor_email', 'executor_password', 'executor_avatar'], 'string', 'max' => 255],
            [['executor_phone'], 'string', 'max' => 11],
            [['executor_telegram'], 'string', 'max' => 64],
            [['executor_email'], 'unique'],
            ['executor_email', 'email'],
            [['executor_avatar'], 'unique'],
            [['executor_phone'], 'unique'],
            [['executor_telegram'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'executor_id' => 'ID исполнителя',
            'city_id' => 'ID города',
            'executor_name' => 'Имя исполнителя',
            'executor_email' => 'Email исполнителя',
            'executor_password' => 'Пароль исполнителя',
            'executor_avatar' => 'Аватар исполнителя',
            'executor_phone' => 'Телефон исполнителя',
            'executor_telegram' => 'Telegram исполнителя',
            'personal_information' => 'Персональная информация',
            'count_tasks' => 'Количество выполненных заданий',
            'executor_rating' => 'Рейтинг исполнителя',
            'executor_status' => 'Статус исполнителя',
            'executor_birthday' => 'День рождения исполнителя',
            'executor_date_add' => 'Дата регистрации',
        ];
    }

    /**
     * Функция возвращения "карты" статусов исполнителя
     * 
     * @return array - массив со статусами исполнителя
     */
    public static function getStatusMap(): array
    {
        return [
            self::STATUS_FREE => 'Открыт для новых заказов',
            self::STATUS_BUSY => 'Занят',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['category_id' => 'category_id'])->viaTable('executor_category', ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[ExecutorCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutorCategoryQuery
     */
    public function getExecutorCategories()
    {
        return $this->hasMany(ExecutorCategory::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery|RespondQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::class, ['task_id' => 'task_id'])->viaTable('respond', ['executor_id' => 'executor_id']);
    }

    public function getTasksCount(): int
    {
        return $this->getTasks()->count();
    }

    public function getFailTasksCount(): int
    {
        return $this->getTasks()->where(['task_status' => Task::STATUS_FAILED])->count();
    }

    public function getSumGrade(): ?int
    {
        return $this->getTasks()->sum('grade');
    }

    public function getCountGrade(): int
    {
        return $this->getTasks()->where(['not in', 'grade', [null]])->count();
    }

    public function getAverageGrade(): float
    {
        return $this->getTasks()
            ->where(['IN', 'task_status', [Task::STATUS_PERFORMED, Task::STATUS_FAILED]])
            ->average('grade');
    }

    public function getRating(): ?int
    {
        $data = Executor::find()
            ->alias('e')
            ->leftJoin(Task::tableName() . ' t', 't.executor_id = e.executor_id')
            ->where(['IN', 't.task_status', [Task::STATUS_PERFORMED, Task::STATUS_FAILED]])
            ->groupby(['e.executor_id'])
            ->having(new Expression('AVG(t.grade) >= :grade', [':grade' => $this->getAverageGrade()]))
            ->orderBy(['AVG(t.grade)' => SORT_DESC])
            ->all();

        for ($i = count($data) - 1; $i >= 0; $i--) {
            if ($data[$i]->executor_id === $this->executor_id) {
                return $i + 1;
            }
        }
        return null;
    }


    /**
     * {@inheritdoc}
     * @return ExecutorQuery the active query used by this AR class.
     */
    /*
    public static function find()
    {
        return new ExecutorQuery(get_called_class());
    }
    */

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    /*
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }
*/
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
