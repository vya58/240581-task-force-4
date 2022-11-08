<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%column_user_role_from_user}}`.
 */
class m221106_141708_drop_column_user_role_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'user_role');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'user_role', $this->integer());
    }
}
