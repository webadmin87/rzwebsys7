<?php

use yii\db\Schema;

class m140828_065644_create_banners_places_table extends \app\modules\main\db\Migration
{

    public $tableName = "banners_places";

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
        ]);

		$this->insertPermission('\app\modules\banners\models\Place');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\banners\models\Place');

    }
}
