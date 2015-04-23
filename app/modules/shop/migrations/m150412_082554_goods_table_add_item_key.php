<?php

use yii\db\Schema;

/**
 * Добавление аттрибута item_key для модели заказанного товара
 * Class m150412_082554_goods_table_add_item_key
 */
class m150412_082554_goods_table_add_item_key extends \app\modules\main\db\Migration
{

    public $tableName = 'shop_goods';

    public function safeUp()
    {

        $this->addColumn("{{%$this->tableName}}", 'item_key', Schema::TYPE_STRING . " NOT NULL DEFAULT ''");

    }

    public function safeDown()
    {

        $this->dropColumn("{{%$this->tableName}}", 'item_key');

    }
}
