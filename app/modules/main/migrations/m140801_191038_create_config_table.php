<?php

use yii\db\Schema;

class m140801_191038_create_config_table extends \yii\db\Migration
{

    public $tableName = "config";

    public function up()
    {

        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'active' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'title' => Schema::TYPE_STRING,
            'key' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
        ]);

        $this->insert($this->tableName, [

            'author_id' => 1,
            'title' => 'Имя сайта',
            'key' => 'siteName',
            'value' => 'Demo site',

        ]);

        $this->insert($this->tableName, [

            'author_id' => 1,
            'title' => 'Email администратора',
            'key' => 'adminEmail',
            'value' => 'admin@example.com',

        ]);

    }

    public function down()
    {

        $this->dropTable($this->tableName);

    }
}
