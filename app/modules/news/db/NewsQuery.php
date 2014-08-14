<?php
namespace app\modules\news\db;

use common\db\ActiveQuery;
use \app\modules\news\models\NewsSection;

/**
 * Class NewsQuery
 * Запрос для модели новостей
 * @package app\modules\news\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NewsQuery extends ActiveQuery
{

    /**
     * Поиск по категории
     * @param array $ids массив идентификаторов категорий новостей
     * @return $this
     */
    public function bySections($ids)
    {

        $class = $this->modelClass;

        $table = $class::tableName();

        $relTable = NewsSection::tableName();

        $this->published();

        if ($ids)
            $this->joinWith('sections', true)->andWhere(["$relTable.id" => $ids])->groupBy("$table.id");

        return $this;

    }

}