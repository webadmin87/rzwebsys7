<?php

use yii\db\Schema;

class m140923_091038_create_payment_table extends \app\modules\main\db\Migration
{

    public $tableName = "shop_payment";

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
			'html'=>Schema::TYPE_TEXT,
			'constraint_class'=>Schema::TYPE_STRING,
        ]);

		$this->insert($this->tableName, ["title"=>"Оплата наличными", "author_id"=>1]);

		$this->insertPermission('\app\modules\shop\models\Payment');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\shop\models\Payment');

    }
}
