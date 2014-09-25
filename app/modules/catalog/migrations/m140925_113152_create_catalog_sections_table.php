<?php

use yii\db\Schema;

class m140925_113152_create_catalog_sections_table extends \app\modules\main\db\Migration
{

    public $tableName = "catalog_sections";

	public function safeUp()
	{

		$this->createTable("{{%$this->tableName}}", [
			'id' => Schema::TYPE_PK,
			'active' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
			'author_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'root' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'lft' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'rgt' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'level' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'title' => Schema::TYPE_TEXT . ' NOT NULL DEFAULT \'\'',
			'code' => Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
			'image'=>Schema::TYPE_TEXT,
			'annotation'=>Schema::TYPE_TEXT,
			'text'=>Schema::TYPE_TEXT,
			'metatitle'=>Schema::TYPE_TEXT,
			'keywords'=>Schema::TYPE_TEXT,
			'description'=>Schema::TYPE_TEXT,
		]);

		$this->insert("{{%$this->tableName}}", [

			'author_id' => 1,
			'root' => 1,
			'lft' => 1,
			'rgt' => 2,
			'level' => 1,

		]);

		$this->insertPermission('\app\modules\catalog\models\CatalogSection');

	}

	public function safeDown()
	{

		$this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\catalog\models\CatalogSection');

	}
}
