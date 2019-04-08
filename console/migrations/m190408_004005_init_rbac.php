<?php

use yii\db\Migration;

/**
 * Class m190408_004005_init_rbac
 */
class m190408_004005_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190408_004005_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190408_004005_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
