<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $category_id
 * @property string $category_name
 * @property string $icon
 *
 * @property ExecutorCategory[] $executorCategories
 * @property Executor[] $executors
 * @property Task[] $tasks
 * @property Category[] $allCategories
 * @property Category[] $categories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
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
            'category_id' => 'ID категории',
            'category_name' => 'Категория',
            'icon' => 'Иконка категории',
        ];
    }

    /**
     * Gets query for [[ExecutorCategories]].
     *
     * @return \yii\db\ActiveQuery|ExecutorCategoryQuery
     */
    public function getExecutorCategories()
    {
        return $this->hasMany(ExecutorCategory::class, ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Executors]].
     *
     * @return \yii\db\ActiveQuery|ExecutorQuery
     */
    public function getExecutors()
    {
        return $this->hasMany(Executor::class, ['executor_id' => 'executor_id'])->viaTable('executor_category', ['category_id' => 'category_id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['category_id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    /*
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
*/
     /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public static function getAllCategories()
    {
        return Category::find()
            ->select('category_name')
            ->indexBy('category_id')
            ->column();
    }

    /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public static function getCategories(array $ids)
    {
        return Category::find()
            ->select('category_name')
            ->where(['in', 'category_id', $ids])
            ->indexBy('category_id')
            ->column();
    }
}
