<?php

use yii\db\Schema;

class m140728_080428_create_news_to_sections_pivot_table extends \yii\db\Migration
{

    public $tableName="news_to_sections";

    public function safeUp()
    {

        $this->createTable($this->tableName,[
            'id'=>Schema::TYPE_PK,
            'news_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'section_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->addForeignKey("news_to_sections_news_id_fk", $this->tableName, "news_id", "news", "id", "CASCADE", "CASCADE");

        $this->addForeignKey("news_to_sections_section_id_fk", $this->tableName, "section_id", "news_sections", "id", "CASCADE", "CASCADE");

    }

    public function down()
    {

        $this->dropTable($this->tableName);

    }
}
