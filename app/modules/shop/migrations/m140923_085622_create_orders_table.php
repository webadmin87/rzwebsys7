<?php

use yii\db\Schema;

class m140923_085622_create_orders_table extends \app\modules\main\db\Migration
{

    public $tableName = "shop_orders";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'status_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'name'=>Schema::TYPE_STRING . ' NOT NULL',
			'email'=>Schema::TYPE_STRING . ' NOT NULL',
			'phone'=>Schema::TYPE_STRING,
			'city'=>Schema::TYPE_STRING . ' NOT NULL',
			'index'=>Schema::TYPE_INTEGER,
			'address'=>Schema::TYPE_STRING . ' NOT NULL',
			'comment'=>Schema::TYPE_TEXT,
			'delivery_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'payment_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'delivery_price'=>Schema::TYPE_MONEY . ' DEFAULT 0',
        ]);

		$this->insertPermission('\app\modules\shop\models\Order');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\shop\models\Order');

    }
}
