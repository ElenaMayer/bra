<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190319_164435_product_size
 */
class m190319_164435_product_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        $this->createTable('{{%product_size}}', [
            'id' => Schema::TYPE_PK,
            'product_id' => Schema::TYPE_INTEGER,
            'size' => Schema::TYPE_STRING,
            'count' => Schema::TYPE_INTEGER,
        ], $tableOptions);

        $this->addForeignKey('fk-product_size-product_id-product_id', '{{%product_size}}', 'product_id', 'product', 'id', 'SET NULL');

        $this->execute('INSERT INTO
                              product_size (`product_id`, `size`, `count`)
                            SELECT
                              product.id,
                              SUBSTRING_INDEX(SUBSTRING_INDEX(product.size, \',\', numbers.n), \',\', -1) size,
                              0
                            FROM
                              (SELECT 1 n union all
                               SELECT 2 union all select 3 union all
                               SELECT 4 union all select 5) numbers INNER JOIN product
                                ON CHAR_LENGTH(product.size)-CHAR_LENGTH(REPLACE(product.size, \',\', \'\'))>=numbers.n-1');

        $this->execute('UPDATE `product` SET `size`= 0 WHERE `size` is null');

        $this->execute('UPDATE `product` SET `size`= 1 WHERE `size` is not null');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190319_164435_product_size cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190319_164435_product_size cannot be reverted.\n";

        return false;
    }
    */
}
