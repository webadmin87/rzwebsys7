<?php
namespace common\db;

use yii\db\ActiveQuery as YiiQuery;

/**
 * Class ActiveQuery
 * Системный ActiveQuery. Предоставляет системные scopes.
 * @property-read string $tableName имя таблицы модели AR
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ActiveQuery extends YiiQuery
{

    /**
     * Устанавливает ограничение по признаку активности
     * @param bool $state если true выбираем активные иначе не активные
     * @return $this
     */

    public function published($state = true)
    {
		$class = $this->modelClass;

		$table = $class::tableName();

        $this->andWhere(["{{%$table}}.{{%active}}" => $state]);
        return $this;
    }

    /**
     * Returns table name of AR model
     * @param null $class
     * @return string
     */
    public function getTableName($class = null)
    {
        $class = is_null($class) ? $this->modelClass : $class;
        return $class::tableName();
    }

}
