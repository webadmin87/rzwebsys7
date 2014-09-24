<?php

use yii\db\Schema;

class m140923_090706_create_delivery_table extends \app\modules\main\db\Migration
{

    public $tableName = "shop_delivery";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'title'=>Schema::TYPE_STRING . ' NOT NULL',
			'text'=>Schema::TYPE_TEXT,
			'price'=>Schema::TYPE_MONEY . ' DEFAULT 0',
			'free_limit'=>Schema::TYPE_INTEGER . ' DEFAULT 0',
			'class'=>Schema::TYPE_STRING,
			'constraint_class'=>Schema::TYPE_STRING,
        ]);

		$this->insert($this->tableName, ["title"=>"Самовывоз"]);

		$this->insertPermission('\app\modules\shop\models\Delivery');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\shop\models\Delivery');

    }
}
