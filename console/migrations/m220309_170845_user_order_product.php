<?php

use yii\db\Migration;

/**
 * Class m220309_170845_user_order_product
 */
class m220309_170845_user_order_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $tableOptions = null;
            if($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(20)->notNull(),
                'lastName' => $this->string(20)->notNull(),
                'username' => $this->string(20)->notNull(),
                'email' => $this->string(40)->notNull()->unique(),
                'address' => $this->string(30)->notNull(),
                'phone' => $this->integer()->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string()->unique(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'role' => $this->smallInteger()->notNull()->defaultValue(4),
            ], $tableOptions);

            $this->createTable('{{Order}}', [
                'idOrder' => $this->primaryKey(),
                'status_request' => $this->smallInteger()->notNull(),
                'status_distribution' => $this->smallInteger()->notNull(),
                'date' => $this->date(),
                'request_time' => $this->time(),
                'delivery_time' => $this->time(),
                'totalPrice' => $this->integer(),
                'idProduct' => $this->integer(),
                'idUser' => $this->integer(),
            ], $tableOptions);

            $this->createTable('{{Order_product}}', [
                'idOrderProduct' => $this->primaryKey(),
                'idOrder' => $this->integer(),
                'idProduct' => $this->integer(),
                'productQuantity' => $this->integer(),
            ], $tableOptions);

            $this->createTable('{{Product}}', [
                'idProduct' => $this->primaryKey(),
                'title' => $this->string(20)->notNull(),
                'description' => $this->text(20)->notNull(),
                'image' => $this->string(200)->notNull(),
                'unitValue' => $this->integer(40)->notNull(),
            ], $tableOptions);

            $this->addForeignKey('FK_user_order', 'Order', 'idUser', 'user', 'id');
            $this->addForeignKey('FK_product_order', 'Order', 'idProduct', 'Product', 'idProduct');
            $this->addForeignKey('FK_order_product_order', 'Order_product', 'idOrder', 'Order', 'idOrder');
            $this->addForeignKey('FK_order_product_product', 'Order_product', 'idProduct', 'Product', 'idProduct');
        }

        /**
         * {@inheritdoc}
         */
        public function safeDown()
        {
            $this->dropForeignKey('FK_order_product_order', 'Order_product');
            $this->dropForeignKey('FK_order_product_product', 'Order_product');
            $this->dropTable('{{%Order}}');
            $this->dropTable('{{%Product}}');
            $this->dropTable('{{%Order_product}}');
            $this->dropTable('{{%user}}');
        }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220309_170845_user_order_product cannot be reverted.\n";

        return false;
    }
    */
}
