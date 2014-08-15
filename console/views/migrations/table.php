<?php
/**
 * Шаблон миграции для создания таблиц сущностей
 * The following variables are available in this view:
 *
 * @var string $className the new migration class name
 */
echo "<?php\n";
?>

use yii\db\Schema;

class <?= $className ?> extends \app\modules\main\db\Migration
{

    public $tableName;

    public function safeUp()
    {

        $this->createTable("{{%$this->tableName}}",[
            'id'=>Schema::TYPE_PK,
            'active'=>Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT true',
            'author_id'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
            'updated_at'=>Schema::TYPE_TIMESTAMP . ' NOT NULL DEFAULT now()',
        ]);

    }

    public function safeDown()
    {

        $this->dropTable("{{%$this->tableName}}");

    }
}
