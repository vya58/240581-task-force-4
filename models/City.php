<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $city_id
 * @property string $city_name
 * @property string|null $city_latitude
 * @property string|null $city_longitude
 *
 * @property Executor[] $executors
 * @property Task[] $tasks
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_name'], 'required'],
            [['city_name'], 'string', 'max' => 50],
            [['city_latitude', 'city_longitude'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_id' => 'ID города',
            'city_name' => 'Город',
            'city_latitude' => 'Географическая широта',
            'city_longitude' => 'Географическая долгота',
        ];
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executor::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['city_id' => 'city_id']);
    }

    /**
     * {@inheritdoc}
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
