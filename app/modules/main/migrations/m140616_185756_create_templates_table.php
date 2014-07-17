<?php

use yii\db\Schema;

class m140616_185756_create_templates_table extends \yii\db\Migration
{

    public $tableName = "templates";

    public function up()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'title'=>Schema::TYPE_STRING,
            'code'=>Schema::TYPE_STRING,
            'cond'=>Schema::TYPE_STRING,
            'text'=>Schema::TYPE_TEXT,
            'cond_type'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'sort'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 500',
        ]);

        $this->insert("{{%$this->tableName}}",[

            'author_id'=>1,
            'title'=>'Demo',
            'code'=>'//demo',
            'text'=>'Demo template',

        ]);

    }

    public function down()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
