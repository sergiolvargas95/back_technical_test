<?php

use yii\db\Migration;

/**
 * Class m220308_210335_order_manager_delivery_product
 */
class m220308_210335_order_manager_delivery_product extends Migration
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

        $this->createTable('{{Order}}', [
            'idOrder' => $this->primaryKey(),
            'status_request' => $this->smallInteger()->notNull(),
            'status_distribution' => $this->smallInteger()->notNull(),
            'date' => $this->date(),
            'request_time' => $this->time(),
            'delivery_time' => $this->time(),
            'totalPrice' => $this->integer(),
            'idUser' => $this->integer(),
            'idManager' => $this->integer(),
            'idDeliveryPerson' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{Manager}}', [
            'idManager' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'lastName' => $this->string(20)->notNull(),
            'nickname' => $this->string(20)->notNull(),
            'email' => $this->string(40)->notNull()->unique(),
            'point_of_sale' => $this->string(30)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
        ], $tableOptions);

        $this->createTable('{{Delivery_person}}', [
            'idDeliveryPerson' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'lastName' => $this->string(20)->notNull(),
            'nickname' => $this->string(20)->notNull(),
            'email' => $this->string(40)->notNull()->unique(),
            'type_of_transport' => $this->string(10)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
        ], $tableOptions);

        $this->createTable('{{Order_product}}', [
            'idOrderProduct' => $this->primaryKey(),
            'idOrder' => $this->integer(),
            'idProduct' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{Product}}', [
            'idProduct' => $this->primaryKey(),
            'title' => $this->string(20)->notNull(),
            'description' => $this->text(20)->notNull(),
            'image' => $this->string(200)->notNull(),
            'unitValue' => $this->integer(40)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('FK_user_order', 'Order', 'idUser', 'user', 'id');
        $this->addForeignKey('FK_manager_order', 'Order', 'idManager', 'Manager', 'idManager');
        $this->addForeignKey('FK_deliveryperson_order', 'Order', 'idDeliveryPerson', 'Delivery_person', 'idDeliveryPerson');
        $this->addForeignKey('FK_order_product_order', 'Order_product', 'idOrder', 'Order', 'idOrder');
        $this->addForeignKey('FK_order_product_product', 'Order_product', 'idProduct', 'Product', 'idProduct');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_user_order', 'Order');
        $this->dropForeignKey('FK_manager_order', 'Order');
        $this->dropForeignKey('FK_deliveryperson_orde', 'Order');
        $this->dropForeignKey('FK_order_product_order', 'Order_product');
        $this->dropForeignKey('FK_order_product_product', 'Order_product');
        $this->dropTable('{{%Order}}');
        $this->dropTable('{{%Manager}}');
        $this->dropTable('{{%Delivery_person}}');
        $this->dropTable('{{%Product}}');
        $this->dropTable('{{%Order_product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220308_210335_order_manager_delivery_product cannot be reverted.\n";

        return false;
    }
    */
}
