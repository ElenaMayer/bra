<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190206_062247_orderSize
 */
class m190206_062247_orderSize extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_item}}', 'size',Schema::TYPE_STRING);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190206_062247_orderSize cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190206_062247_orderSize cannot be reverted.\n";

        return false;
    }
    */
}
