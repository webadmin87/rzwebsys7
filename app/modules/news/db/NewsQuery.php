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
     * @param array $values массив значений атрибута
     * @param string $attr имя атрибута категорий по которому происходит фильтрация
     * @return $this
     */
    public function bySections($values, $attr="id")
    {

        $class = $this->modelClass;

        $table = $class::tableName();

        $relTable = NewsSection::tableName();

        $this->published();

        if ($values)
            $this->joinWith('sections', true)->andWhere(["{{%$relTable}}.{{%$attr}}" => $values])->groupBy("{{%$table}}.{{%id}}");

        return $this;

    }

}