<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190129_094106_order
 */
class m190129_094106_order extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'subcategories',Schema::TYPE_STRING);
        $this->addColumn('{{%product}}', 'weight',Schema::TYPE_FLOAT);
        $this->addColumn('{{%product}}', 'count',Schema::TYPE_INTEGER);

        $this->addColumn('{{%order}}', 'fio',Schema::TYPE_STRING);
        $this->addColumn('{{%order}}', 'shipping_cost',Schema::TYPE_INTEGER);
        $this->addColumn('{{%order}}', 'city',Schema::TYPE_STRING);
        $this->addColumn('{{%order}}', 'shipping_method',Schema::TYPE_STRING);
        $this->addColumn('{{%order}}', 'payment_method',Schema::TYPE_STRING);
        $this->addColumn('{{%order}}', 'zip',Schema::TYPE_INTEGER);
        $this->addColumn('{{%order}}', 'payment',Schema::TYPE_BOOLEAN);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%product_relation}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'child_id' => Schema::TYPE_INTEGER,
        ], $tableOptions);
        $this->addForeignKey('fk-product_relation-parent_id-product-id', '{{%product_relation}}', 'parent_id', '{{%product}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_relation-child_id-product-id', '{{%product_relation}}', 'child_id', '{{%product}}', 'id', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190129_094106_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_094106_order cannot be reverted.\n";

        return false;
    }
    */
}
