<?php

use yii\db\Schema;

class m150219_073312_create_groups_to_includes_table extends \app\modules\main\db\Migration
{

    public $tableName = "groups_to_includes";

    public function safeUp()
    {

        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'include_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'group_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->addForeignKey($this->tableName."_include_id_fk", $this->tableName, "include_id", "includes", "id", "CASCADE", "CASCADE");

        $this->addForeignKey($this->tableName."_group_id_fk", $this->tableName, "group_id", "include_groups", "id", "CASCADE", "CASCADE");


    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
