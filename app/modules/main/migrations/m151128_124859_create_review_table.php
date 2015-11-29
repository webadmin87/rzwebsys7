<?php

use yii\db\Schema;
use app\modules\main\models\User;

class m151128_124859_create_review_table extends \app\modules\main\db\Migration
{

    public $tableName = 'review';

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',

            'username' => Schema::TYPE_STRING . " NOT NULL DEFAULT ''",
            'email' => Schema::TYPE_STRING,
            'rating' => Schema::TYPE_FLOAT . ' NOT NULL DEFAULT 0',
            'text' => Schema::TYPE_TEXT . " NOT NULL DEFAULT ''",

            'model' => Schema::TYPE_TEXT . " NOT NULL DEFAULT ''",
            'item_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',

            'source_model' => Schema::TYPE_TEXT . " NOT NULL DEFAULT ''",
            'source_item_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',

            'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'rating_total' => Schema::TYPE_FLOAT . ' NOT NULL DEFAULT 0',
            'rating_average' => Schema::TYPE_FLOAT . ' NOT NULL DEFAULT 0',
        ]);

	    $this->insertPermission('\app\modules\main\models\Review', '\app\modules\main\rbac\ReviewConstraint', User::ROLE_ADMIN, null, ['create']);
	    $this->insertPermission('\app\modules\main\models\Review', '\app\modules\main\rbac\ReviewConstraint', User::ROLE_USER, ['create', 'read']);

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

	    $this->deletePermission('\app\modules\main\models\Review');
	    $this->deletePermission('\app\modules\main\models\Review', User::ROLE_USER);

    }
}
