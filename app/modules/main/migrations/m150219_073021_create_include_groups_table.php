<?php

use yii\db\Schema;

class m150219_073021_create_include_groups_table extends \app\modules\main\db\Migration
{

    public $tableName = "include_groups";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'title'=>Schema::TYPE_STRING . ' NOT NULL',
            'code'=>Schema::TYPE_STRING . ' NOT NULL',
            'cond' => Schema::TYPE_STRING,
            'cond_type' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'sort' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 500',
        ]);

        $this->insertPermission('\app\modules\main\models\IncludeGroup');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

        $this->deletePermission('\app\modules\main\models\IncludeGroup');

    }
}
