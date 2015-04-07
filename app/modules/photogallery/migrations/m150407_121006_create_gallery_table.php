<?php

use yii\db\Schema;

class m150407_121006_create_gallery_table extends \app\modules\main\db\Migration
{

    public $tableName = "photogallery_galleries";

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
            'text' => Schema::TYPE_TEXT,
            'sort' => Schema::TYPE_INTEGER . ' DEFAULT 500',
        ]);

        $this->insertPermission('\app\modules\photogallery\models\Gallery');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

        $this->deletePermission('\app\modules\photogallery\models\Gallery');

    }
}
