<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190315_141143_order
 */
class m190315_141143_order extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'payment_url',Schema::TYPE_STRING);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190315_141143_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_141143_order cannot be reverted.\n";

        return false;
    }
    */
}
