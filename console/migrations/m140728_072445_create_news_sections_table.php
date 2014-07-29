<?php

use yii\db\Schema;

class m140728_072445_create_news_sections_table extends \yii\db\Migration
{

    public $tableName = "news_sections";

    public function up()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'root'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'lft'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'rgt'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'level'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'title'=>Schema::TYPE_TEXT . ' NOT NULL DEFAULT \'\'',
            'code'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT \'\'',
        ]);

        $this->insert("{{%$this->tableName}}",[

            'author_id'=>1,
            'root'=>1,
            'lft'=>1,
            'rgt'=>2,
            'level'=>1,

        ]);

    }

    public function down()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
