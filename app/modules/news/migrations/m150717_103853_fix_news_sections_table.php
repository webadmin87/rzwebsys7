<?php

use yii\db\Schema;

class m150717_103853_fix_news_sections_table extends \app\modules\main\db\Migration
{

    public $tableName = "news_sections";

    public function safeUp()
    {

        $this->addColumn($this->tableName, "metatitle", Schema::TYPE_TEXT);
        $this->addColumn($this->tableName, "keywords", Schema::TYPE_TEXT);
        $this->addColumn($this->tableName, "description", Schema::TYPE_TEXT);



    }

    public function safeDown()
    {

        $this->dropColumn($this->tableName, "metatitle");
        $this->dropColumn($this->tableName, "keywords");
        $this->dropColumn($this->tableName, "description");

    }
}
