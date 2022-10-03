<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public static function selectAllCategories()
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
    public static function selectCategories(array $ids)
    {
        return Category::find()
            ->select('category_name')
            ->where(['in', 'category_id', $ids])
            ->indexBy('category_id')
            ->column();
    }

    /**
     * {@inheritdoc}
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
