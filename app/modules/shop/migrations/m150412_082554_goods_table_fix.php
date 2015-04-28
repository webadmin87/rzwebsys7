<?php

use yii\db\Schema;

/**
 * Добавление аттрибутов
 *  item_key - ключ(идентификатор заказанного товара)
 *  client_attrs - атрибуты, переданные клиентом для заказанного товара
 * Class m150412_082554_goods_table_fix
 */
class m150412_082554_goods_table_fix extends \app\modules\main\db\Migration
{

    public $tableName = 'shop_goods';

    public function safeUp()
    {

        $this->addColumn("{{%$this->tableName}}", 'item_key', Schema::TYPE_STRING . " NOT NULL DEFAULT ''");
        $this->addColumn("{{%$this->tableName}}", 'client_attrs', Schema::TYPE_TEXT);

    }

    public function safeDown()
    {

        $this->dropColumn("{{%$this->tableName}}", 'item_key');
        $this->dropColumn("{{%$this->tableName}}", 'client_attrs');

    }
}
