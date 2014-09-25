<?php

use yii\db\Schema;

class m140925_115501_create_producer_table extends \app\modules\main\db\Migration
{

    public $tableName = "catalog_producers";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'title' => Schema::TYPE_TEXT . ' NOT NULL',
			'code' => Schema::TYPE_STRING . ' NOT NULL',
			'image' => Schema::TYPE_TEXT,
			'annotation' => Schema::TYPE_TEXT,
			'text' => Schema::TYPE_TEXT,
        ]);

		$this->insertPermission('\app\modules\catalog\models\Producer');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\catalog\models\Producer');

    }
}
