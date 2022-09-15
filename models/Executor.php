<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "executors".
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
 * @property Categories[] $categories
 * @property Cities $city
 * @property ExecutorsCategories[] $executorsCategories
 * @property ExecutorsTasks[] $executorsTasks
 * @property Reviews[] $reviews
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 */
class Executor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executors';
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
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'executor_id' => 'Executor ID',
            'city_id' => 'City ID',
            'executor_name' => 'Executor Name',
            'executor_email' => 'Executor Email',
            'executor_password' => 'Executor Password',
            'executor_avatar' => 'Executor Avatar',
            'executor_phone' => 'Executor Phone',
            'executor_telegram' => 'Executor Telegram',
            'personal_information' => 'Personal Information',
            'count_tasks' => 'Count Tasks',
            'executor_rating' => 'Executor Rating',
            'executor_status' => 'Executor Status',
            'executor_birthday' => 'Executor Birthday',
            'executor_date_add' => 'Executor Date Add',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['category_id' => 'category_id'])->viaTable('executors_categories', ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[ExecutorsCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsCategoriesQuery
     */
    public function getExecutorsCategories()
    {
        return $this->hasMany(ExecutorsCategories::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[ExecutorsTasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsTasksQuery
     */
    public function getExecutorsTasks()
    {
        return $this->hasMany(ExecutorsTasks::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewsQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['task_id' => 'task_id'])->viaTable('executors_tasks', ['executor_id' => 'executor_id']);
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
