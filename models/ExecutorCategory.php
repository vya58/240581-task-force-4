<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "executors_categories".
 *
 * @property int $id
 * @property int $executor_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Executors $executor
 */
class ExecutorCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'executors_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'category_id'], 'required'],
            [['executor_id', 'category_id'], 'integer'],
            [['category_id', 'executor_id'], 'unique', 'targetAttribute' => ['category_id', 'executor_id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Executors::class, 'targetAttribute' => ['executor_id' => 'executor_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executor_id' => 'ID исполнителя',
            'category_id' => 'ID категории',
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
     * @return ExecutorCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExecutorCategoryQuery(get_called_class());
    }
}
