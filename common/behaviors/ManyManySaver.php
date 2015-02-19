<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class ManyManySaver
 * Поведение для сохранения связанных через MANY MANY записей
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ManyManySaver extends Behavior
{

    const ATTR_SUFF = "Ids";
    /**
     * @var array массив имен связей для сохранения
     */

    public $names = [];

    /**
     * @inheritdoc
     */

    public function events()
    {
        return [

            ActiveRecord::EVENT_AFTER_INSERT => [$this, "afterSave"],
            ActiveRecord::EVENT_AFTER_UPDATE => [$this, "afterSave"],

        ];
    }

    /**
     * Сохранение связей
     */

    public function afterSave()
    {

		$this->owner->setIsNewRecord(false);

        foreach ($this->names AS $name) {

            $attr = $this->getAttributeName($name);

            if ($this->owner->$attr !== null) {

                $query = $this->owner->{"get" . ucfirst($name)}();

                $modelClass = $query->modelClass;

                $related = $query->all();

                foreach ($related AS $rel) {

                    $this->owner->unlink($name, $rel, true);

                }

                if (empty($this->owner->$attr))
                    continue;

                $newRelated = $modelClass::find()->where(["id" => $this->owner->$attr])->all();

                usort($newRelated, function($val1, $val2) use ($attr){

                    $key1 = array_search($val1->id, $this->owner->$attr);
                    $key2 = array_search($val2->id, $this->owner->$attr);

                    if($key1>$key2)
                        return 1;
                    elseif($key1<$key2)
                        return -1;
                    else
                        return 0;

                });

                foreach ($newRelated as $newRel) {
                    $this->owner->link($name, $newRel);
                }

            }

        }

    }

    /**
     * Возвращает имя атрибута хранящего идентификаторы привязываемы записей
     * @param string $name имя звязи
     * @return string
     */

    public function getAttributeName($name)
    {

        return $name . static::ATTR_SUFF;

    }

    /**
     * Возвращает массив идентификаторов связанных записей
     * @param string $name имя связи
     * @return array
     */

    public function getManyManyIds($name)
    {

        $models = $this->owner->$name;

        $ids = [];

        foreach ($models AS $model)
            $ids[] = $model->id;

        return $ids;
    }

}