<?php

use yii\db\Schema;

class m140828_065653_create_banners_table extends \app\modules\main\db\Migration
{

    public $tableName = "banners_banners";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'title'=>Schema::TYPE_STRING . ' NOT NULL',
			'place_id'=>Schema::TYPE_INTEGER . ' NOT NULL',
			'image'=>Schema::TYPE_TEXT,
			'link'=>Schema::TYPE_TEXT,
			'target'=>Schema::TYPE_STRING,
			'text'=>Schema::TYPE_TEXT,
			'width'=>Schema::TYPE_INTEGER,
			'height'=>Schema::TYPE_INTEGER,
			'sort'=>Schema::TYPE_INTEGER,
        ]);

		$this->insertPermission('\app\modules\banners\models\Banner');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\banners\models\Banner');

    }
}
