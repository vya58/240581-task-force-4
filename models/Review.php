<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $review_id
 * @property int $customer_id
 * @property int $executor_id
 * @property int $grade
 * @property string|null $review
 *
 * @property Customer $customer
 * @property Executor $executor
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
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
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'customer_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executor::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'review_id' => 'ID отзыва',
            'customer_id' => 'ID заказчика',
            'executor_id' => 'ID исполнителя',
            'grade' => 'Оценка',
            'review' => 'Отзыв',
        ];
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
     * {@inheritdoc}
     * @return ReviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewQuery(get_called_class());
    }
}
