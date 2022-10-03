<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Customer]].
 *
 * @see Customer
 */
class CustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public static function selectCustomer($id)
    {
        return Customer::find()
            ->where(['customer_id' => $id])
            ->all();
    }

    /**
     * {@inheritdoc}
     * @return Customer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Customer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
