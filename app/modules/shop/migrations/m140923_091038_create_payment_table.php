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
			'html'=>Schema::TYPE_TEXT,
			'constraint_class'=>Schema::TYPE_STRING,
        ]);

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
