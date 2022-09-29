<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $customer_id
 * @property string $customer_email
 * @property string $customer_password
 * @property string $customer_name
 * @property string|null $customer_avatar
 * @property string $customer_date_add
 *
 * @property Review[] $reviews
 * @property Task[] $tasks
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_email', 'customer_password', 'customer_name', 'customer_date_add'], 'required'],
            [['customer_date_add'], 'safe'],
            [['customer_email', 'customer_password', 'customer_avatar'], 'string', 'max' => 255],
            [['customer_name'], 'string', 'max' => 50],
            [['customer_email'], 'unique'],
            [['customer_avatar'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'ID заказчика',
            'customer_email' => 'Email заказчика',
            'customer_password' => 'Пароль заказчика',
            'customer_name' => 'Имя заказчика',
            'customer_avatar' => 'Аватар заказчика',
            'customer_date_add' => 'Дата регитрации заказчика',
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['customer_id' => 'customer_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
