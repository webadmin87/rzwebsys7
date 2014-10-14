<?php

use yii\db\Schema;

class m140924_110805_create_status_table extends \app\modules\main\db\Migration
{

    public $tableName = "shop_status";

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
			'title'=>Schema::TYPE_STRING . ' NOT NULL',
			'text'=>Schema::TYPE_TEXT,
			'tpl'=>Schema::TYPE_STRING,
            'default'=>Schema::TYPE_BOOLEAN . ' DEFAULT false',
        ]);

		$stats = [

			["title"=>"Новый", "tpl"=>"new", "default"=>true, "author_id"=>1],
			["title"=>"Готов", "tpl"=>"ready", "author_id"=>1],
			["title"=>"Отменен", "tpl"=>"cancel", "author_id"=>1],

		];

		foreach($stats AS $stat) {

			$this->insert($this->tableName, $stat);

		}

		$this->insertPermission('\app\modules\shop\models\Status');

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

		$this->deletePermission('\app\modules\shop\models\Status');

    }
}
