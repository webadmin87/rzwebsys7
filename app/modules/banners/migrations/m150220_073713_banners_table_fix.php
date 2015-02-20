<?php

use yii\db\Schema;

class m150220_073713_banners_table_fix extends \app\modules\main\db\Migration
{

    public $tableName = "banners_banners";

    public function safeUp()
    {

        $this->addColumn($this->tableName, "cond", Schema::TYPE_STRING);
        $this->addColumn($this->tableName, "cond_type", Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');


    }

    public function safeDown()
    {

        $this->dropColumn($this->tableName, "cond");
        $this->dropColumn($this->tableName, "cond_type");


    }
}
