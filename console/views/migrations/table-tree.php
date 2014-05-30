<?php
/**
 * Шаблон миграции для создания таблиц, древовидных сущностей
 * The following variables are available in this view:
 *
 * @var string $className the new migration class name
 */
echo "<?php\n";
?>

use yii\db\Schema;

class <?= $className ?> extends \yii\db\Migration
{

    public $tableName;

    public function up()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'root'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'lft'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'rgt'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'level'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->insert("{{%$this->tableName}}",[

            'id'=>1,
            'author_id'=>1,
            'root'=>1,
            'lft'=>1,
            'rgt'=>1,
            'level'=>1,

        ]);

    }

    public function down()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
