<?php
namespace app\modules\shop\db;

use common\db\ActiveQuery;

/**
 * Class StatusQuery
 * Запрос для модели статусов
 * @package app\modules\shop\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class StatusQuery extends ActiveQuery
{

    /**
     * Статус по умолчанию
     * @return static
     */
    public function byDefault()
    {
        $class = $this->modelClass;

        $table = $class::tableName();

        return $this->andWhere(["{{%$table}}.{{%default}}"=>true]);
    }

}