<?php

use yii\db\Schema;

class m140923_092729_create_goods_table extends \app\modules\main\db\Migration
{

    public $tableName = "shop_goods";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'order_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'title'=>Schema::TYPE_STRING,
			'price'=>Schema::TYPE_MONEY . ' NOT NULL DEFAULT 0',
			'discount'=>Schema::TYPE_FLOAT . ' DEFAULT 0',
			'qty'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
			'item_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'item_class'=>Schema::TYPE_STRING . ' NOT NULL',
			'attrs'=>Schema::TYPE_TEXT,
			'link'=>Schema::TYPE_TEXT,
        ]);

		$this->addForeignKey("shop_goods_order_id_fk", $this->tableName, "order_id", "shop_orders", "id", "CASCADE", "CASCADE");

		$this->insertPermission('\app\modules\shop\models\Good');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\shop\models\Good');

    }
}
