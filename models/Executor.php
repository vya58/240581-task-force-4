<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "executor".
 *
 * @property int $executor_id
 * @property int|null $city_id
 * @property string $executor_name
 * @property string $executor_email
 * @property string $executor_password
 * @property string|null $executor_avatar
 * @property string|null $executor_phone
 * @property string|null $executor_telegram
 * @property string|null $personal_information
 * @property int|null $count_tasks
 * @property float|null $executor_rating
 * @property int|null $executor_status
 * @property string|null $executor_birthday
 * @property string $executor_date_add
 *
 * @property Category[] $categories
 * @property City $city
 * @property ExecutorCategory[] $executorCategories
 * @property ExecutorTask[] $executorTasks
 * @property Review[] $reviews
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class Executor extends \yii\db\ActiveRecord
{
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
            [['city_id', 'count_tasks', 'executor_status'], 'integer'],
            [['executor_name', 'executor_email', 'executor_password', 'executor_date_add'], 'required'],
            [['executor_rating'], 'number'],
            [['executor_birthday', 'executor_date_add'], 'safe'],
            [['executor_name'], 'string', 'max' => 50],
            [['executor_email', 'executor_password', 'executor_avatar', 'personal_information'], 'string', 'max' => 255],
            [['executor_phone'], 'string', 'max' => 11],
            [['executor_telegram'], 'string', 'max' => 64],
            [['executor_email'], 'unique'],
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
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['category_id' => 'category_id'])
            ->viaTable('executor_category', ['executor_id' => 'executor_id']);
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
     * Gets query for [[ExecutorTasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutorTaskQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(ExecutorTask::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['executor_id' => 'executor_id']);
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
        return $this->hasMany(Task::class, ['task_id' => 'task_id'])
            ->viaTable('executor_task', ['executor_id' => 'executor_id']);
    }

    /**
     * {@inheritdoc}
     * @return ExecutorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecutorQuery(get_called_class());
    }
}
