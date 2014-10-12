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
			'tpl'=>Schema::TYPE_TEXT,
            'default'=>Schema::TYPE_BOOLEAN . ' DEFAULT false',
        ]);

		$stats = [

			["title"=>"Новый", "tpl"=>"Вашему заказу присвоен номер {id}. Наш менеджер скоро свяжеться с вами для подтверждения заказа.", "default"=>true, "author_id"=>1],
			["title"=>"В обработке", "tpl"=>"Ваш заказ {id} поступил в обработку.", "author_id"=>1],
			["title"=>"Выполнен", "tpl"=>"Ваш заказ {id} выполнен.", "author_id"=>1],
			["title"=>"Отменен", "tpl"=>"Ваш заказ {id} отменен.", "author_id"=>1],

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
