<?php

use yii\db\Schema;

class m140527_182017_create_permission_table extends \yii\db\Migration
{

    public $tableName = "permission";

    public function up()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'role'=>Schema::TYPE_STRING . ' NOT NULL',
            'model'=>Schema::TYPE_STRING . ' NOT NULL',
            'create'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
            'read'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
            'update'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
            'delete'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT false',
            'constraint'=>Schema::TYPE_STRING,
            'forbidden_attrs'=>Schema::TYPE_TEXT,
        ]);

    }

    public function down()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
