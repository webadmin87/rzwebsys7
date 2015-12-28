<?php

class m151228_143046_alter_user_unique_constraint extends \app\modules\main\db\Migration
{

    public $tableName = "user";

    public function safeUp()
    {
       $this->execute("ALTER TABLE \"$this->tableName\" ADD CONSTRAINT user_uniq_username_constraint UNIQUE (username);");
       $this->execute("ALTER TABLE \"$this->tableName\" ADD CONSTRAINT user_uniq_email_constraint UNIQUE (email);");
    }

    public function safeDown()
    {
	    $this->execute("ALTER TABLE \"$this->tableName\" DROP CONSTRAINT user_uniq_username_constraint UNIQUE (username);");
	    $this->execute("ALTER TABLE \"$this->tableName\" DROP CONSTRAINT user_uniq_email_constraint UNIQUE (email);");
    }
}
