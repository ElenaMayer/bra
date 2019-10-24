<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m191012_134802_order_shipping_area
 */
class m191012_134802_order_shipping_area extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->addColumn('{{%order}}', 'shipping_area',Schema::TYPE_STRING);
        $this->addColumn('{{%order}}', 'is_try_on',Schema::TYPE_BOOLEAN);

        $this->execute('UPDATE `order` SET `is_try_on` = 1, `shipping_method` = \'courier\' WHERE `shipping_method` = \'tryon\'');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191012_134802_order_shipping_area cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191012_134802_order_shipping_area cannot be reverted.\n";

        return false;
    }
    */
}
