<?php

use yii\db\Schema;

class m140623_175657_create_includes_table extends \yii\db\Migration
{

    public $tableName = "includes";

    public function up()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            "title"=>Schema::TYPE_STRING,
            "code"=>Schema::TYPE_STRING,
            "text"=>Schema::TYPE_TEXT,
        ]);

    }

    public function down()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
