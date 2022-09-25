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
 *
 * @property Category $category
 * @property City $city
 * @property Customer $customer
 * @property Executor $executor
 * @property ExecutorTask[] $executorTasks
 * @property Executor[] $executors
 * @property File[] $files
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
            [['customer_id', 'executor_id', 'category_id', 'city_id', 'task_budget'], 'integer'],
            [['task_date_create', 'task_deadline'], 'safe'],
            [['task_name'], 'string', 'max' => 50],
            [['task_essence'], 'string', 'max' => 80],
            [['task_details', 'task_latitude', 'task_longitude'], 'string', 'max' => 255],
            [['task_status'], 'string', 'max' => 10],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executor::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'city_id', 'city_id' => null]],
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
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['category_id' => 'category_id']);
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|CustomerQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['customer_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|ExecutorQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Executor::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[ExecutorTasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutorTaskQuery
     */
    public function getExecutorTasks()
    {
        return $this->hasMany(ExecutorTask::class, ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executor::class, ['executor_id' => 'executor_id'])
            ->viaTable('executor_task', ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|FileQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, ['task_id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
