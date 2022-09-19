<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $city_id
 * @property string $city_name
 * @property string|null $city_latitude
 * @property string|null $city_longitude
 *
 * @property Executors[] $executors
 * @property Tasks[] $tasks
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
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
            'city_latitude' => 'Географическая широта города',
            'city_longitude' => 'Географическая долгота города',
        ];
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executors::class, ['city_id' => 'city_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['city_id' => 'city_id']);
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
