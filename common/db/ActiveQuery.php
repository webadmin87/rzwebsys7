<?php
namespace common\db;

use yii\db\ActiveQuery as YiiQuery;

/**
 * Class ActiveQuery
 * Системный ActiveQuery. Предоставляет системные scopes.
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
        $this->andWhere(['active' => $state]);
        return $this;
    }

}
