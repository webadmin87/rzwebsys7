<?php
namespace common\components;

use yii\base\Object;
use common\db\TActiveRecord;

/**
 * Class TreeFinder
 * Поиск значений по дереву
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TreeFinder extends Object
{

    /**
     * Делает обход дерева от модели вверх по предкам до корня.
     * Возвращает первое не пустое значение атрибута обходимых моделей.
     * @param TActiveRecord $model модель
     * @param string $attr атрибут
     * @param bool $default значение по умолчанию
     * @return bool|mixed
     */
    public function findValue(TActiveRecord $model, $attr, $default = false)
    {

        if(!empty($model->$attr))
            return $model->$attr;

        $models = $model->ancestors()->all();

        $models = array_reverse($models);

        foreach($models AS $m) {
            if(!empty($m->$attr))
                return $m->$attr;
        }

        return $default;

    }

}