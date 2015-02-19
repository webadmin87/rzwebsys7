<?php

namespace common\components;

use yii\base\Object;

/**
 * Class TagsConverter
 * Конвертор тегов формируемых виджетом \common\widgets\SortedTags в массив идентификаторов моделей и обратно
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TagsConverter extends Object {

    /**
     * Преобразует строку тегов в массив идентификаторов
     * @param string $tags
     * @return array
     */
    public function tagsToArray($tags)
    {

        preg_match_all('/#(\d+)\s/i', $tags, $m);

        return $m[1];

    }

    /**
     * Преобразует массив моделей в строку тегов
     * @param \common\db\ActiveRecord[] $models массив моделей
     * @param string $labelAttr имя атрибута модели содержащего подпись
     * @return string
     */
    public function arrayToTags($models, $labelAttr="title")
    {

        $str = [];

        foreach($models AS $model) {

            $str[] = sprintf("#%s %s", $model->id, $model->$labelAttr);

        }

        return implode(",", $str);

    }

} 