<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $category_id
 * @property string $category_name
 * @property string $icon
 *
 * @property Executors[] $executors
 * @property ExecutorsCategories[] $executorsCategories
 * @property Tasks[] $tasks
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'icon'], 'required'],
            [['category_name'], 'string', 'max' => 30],
            [['icon'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'ID категории задания',
            'category_name' => 'Категория задания',
            'icon' => 'Иконка категории',
        ];
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executors::class, ['executor_id' => 'executor_id'])->viaTable('executors_categories', ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[ExecutorsCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutorsCategoriesQuery
     */
    public function getExecutorsCategories()
    {
        return $this->hasMany(ExecutorsCategories::class, ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
