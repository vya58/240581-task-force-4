<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $review_id
 * @property int $customer_id
 * @property int $executor_id
 * @property int $grade
 * @property string|null $review
 *
 * @property Customers $customer
 * @property Executors $executor
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'executor_id', 'grade'], 'required'],
            [['customer_id', 'executor_id', 'grade'], 'integer'],
            [['review'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executors::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'review_id' => 'Review ID',
            'customer_id' => 'Customer ID',
            'executor_id' => 'Executor ID',
            'grade' => 'Grade',
            'review' => 'Review',
        ];
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
     * {@inheritdoc}
     * @return ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewQuery(get_called_class());
    }
}
