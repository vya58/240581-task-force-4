<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
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
 * @property Categories $category
 * @property Cities $city
 * @property Customers $customer
 * @property Executors $executor
 * @property Executors[] $executors
 * @property ExecutorsTasks[] $executorsTasks
 * @property Files[] $files
 */
class Task extends \yii\db\ActiveRecord
{
    private const STATUS_NEW = 'statusNew';
    private const STATUS_CANCELED = 'statusCanceled';
    private const STATUS_IN_WORK = 'statusInWork';
    private const STATUS_PERFORMED = 'statusPerformed';
    private const STATUS_FAILED = 'statusFailed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'category_id', 'task_name', 'task_essence', 'task_details', 'task_date_create'], 'required'],
            [['customer_id', 'executor_id', 'category_id', 'city_id', 'task_budget', 'task_status'], 'integer'],
            [['task_date_create', 'task_deadline'], 'safe'],
            [['task_name'], 'string', 'max' => 50],
            [['task_essence'], 'string', 'max' => 80],
            [['task_details', 'task_latitude', 'task_longitude'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executors::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'city_id']],
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
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['category_id' => 'category_id']);
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
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|CustomersQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::class, ['customer_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(Executors::class, ['executor_id' => 'executor_id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executors::class, ['executor_id' => 'executor_id'])->viaTable('executors_tasks', ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[ExecutorsTasks]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsTasksQuery
     */
    public function getExecutorsTasks()
    {
        return $this->hasMany(ExecutorsTasks::class, ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|FilesQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['task_id' => 'task_id']);
    }

    /**
     //* {@inheritdoc}
    // * @return TaskQuery the active query used by this AR class.
     */
    /*
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
    */
}
