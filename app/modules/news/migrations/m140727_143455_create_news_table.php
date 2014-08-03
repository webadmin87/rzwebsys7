<?php

use yii\db\Schema;

class m140727_143455_create_news_table extends \app\modules\main\db\Migration
{

    public $tableName = "news";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'title'=>Schema::TYPE_TEXT . ' NOT NULL',
            'code'=>Schema::TYPE_STRING . ' NOT NULL',
            'image'=>Schema::TYPE_TEXT,
            'annotation'=>Schema::TYPE_TEXT,
            'text'=>Schema::TYPE_TEXT,
            'date'=>Schema::TYPE_DATE,
            'comments'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
            'metatitle'=>Schema::TYPE_TEXT,
            'keywords'=>Schema::TYPE_TEXT,
            'description'=>Schema::TYPE_TEXT,
        ]);

        $this->insertPermission('\app\modules\news\models\News');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

        $this->deletePermission('\app\modules\news\models\News');

    }
}
