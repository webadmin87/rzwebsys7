<?php
namespace app\modules\catalog\db;

use common\db\ActiveQuery;
use \app\modules\catalog\models\CatalogSection;

/**
 * Class CatalogQuery
 * Запрос для модели элемента каталога товаров
 * @package app\modules\catalog\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogQuery extends ActiveQuery
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

        $relTable = CatalogSection::tableName();

        $this->published();

        if ($ids)
            $this->joinWith('sections', true)->andWhere(["$relTable.id" => $ids])->groupBy("$table.id");

        return $this;

    }

}