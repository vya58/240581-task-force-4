<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $task_id
 * @property int $customer_id
 * @property int|null $executor_id
 * @property int $category_id
 * @property int|null $city_id
 * @property string $task_name
 * @property string $task_essence
 * @property string $task_details
 * @property int|null $task_budget
 * @property string|null $task_latitude
 * @property string|null $task_longitude
 * @property string $task_date_create
 * @property string|null $task_status
 * @property string|null $task_deadline
 * @property int|null $grade
 * @property string|null $review
 * @property string|null $review_data_create
 *
 * @property Category $category
 * @property City $city
 * @property User $customer
 * @property User $executor
 * @property User[] $respondedExecutors
 * @property File[] $files
 * @property Respond[] $responds
 */
class Task extends \yii\db\ActiveRecord
{
    public const STATUS_NEW = 'New';
    public const STATUS_CANCELED = 'Canceled';
    public const STATUS_IN_WORK = 'InWork';
    public const STATUS_PERFORMED = 'Performed';
    public const STATUS_FAILED = 'Failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'category_id', 'task_name', 'task_essence', 'task_details', 'task_date_create'], 'required'],
            [['customer_id', 'executor_id', 'category_id', 'city_id', 'task_budget', 'grade'], 'integer'],
            [['task_details'], 'string'],
            [['task_date_create', 'task_deadline', 'review_data_create'], 'safe'],
            [['task_name'], 'string', 'max' => 50],
            [['task_essence'], 'string', 'max' => 80],
            [['task_latitude', 'task_longitude', 'review'], 'string', 'max' => 255],
            [['task_status'], 'string', 'max' => 10],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'user_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'user_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'city_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'ID задания',
            'customer_id' => 'ID заказчика',
            'executor_id' => 'ID исполнителя',
            'category_id' => 'ID категории задания',
            'city_id' => 'ID города',
            'task_name' => 'Задание',
            'task_essence' => 'Требования задания',
            'task_details' => 'Подробности задания',
            'task_budget' => 'Бюджет задания',
            'task_latitude' => 'Широта локации задания',
            'task_longitude' => 'Долгота локации задания',
            'task_date_create' => 'Дата размещения задания',
            'task_status' => 'Статус задания',
            'task_deadline' => 'Срок исполнения задания',
            'grade' => 'Оценка задания',
            'review' => 'Отзыв',
            'review_date_create' => 'Дата создания отзыва',
        ];
    }

    /**
     * Функция возвращения "карты" статусов задания
     * 
     * @return array - массив со статусами заданий
     */
    public static function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_PERFORMED => 'Выполнено',
            self::STATUS_FAILED => 'Провалено',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['category_id' => 'category_id']);
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::class, ['user_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['user_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespondedExecutors()
    {
        return $this->hasMany(User::class, ['user_id' => 'executor_id'])->viaTable('respond', ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::class, ['task_id' => 'task_id']);
    }
}
