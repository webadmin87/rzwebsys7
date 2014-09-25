<?php

use yii\db\Schema;

class m140925_113213_create_catalog_to_sections_pivot_table extends \app\modules\main\db\Migration
{

    public $tableName="catalog_catalog_to_sections";

	public function safeUp()
	{

		$this->createTable($this->tableName, [
			'id' => Schema::TYPE_PK,
			'catalog_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
			'section_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
		]);

		$this->addForeignKey("catalog_to_sections_catalog_id_fk", $this->tableName, "catalog_id", "catalog_catalog", "id", "CASCADE", "CASCADE");

		$this->addForeignKey("catalog_to_sections_section_id_fk", $this->tableName, "section_id", "catalog_sections", "id", "CASCADE", "CASCADE");

	}

	public function down()
	{

		$this->dropTable($this->tableName);

	}
}
