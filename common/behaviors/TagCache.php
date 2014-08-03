<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class TagCache
 * Поведение тегированного кеширования
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TagCache extends Behavior
{

    const PREFFIX = "tag_cache_";

    /**
     * Вызывается после изменения модели
     */

    public function afterUpdate()
    {

        $this->setItemTag();

    }

    /**
     * Устанавливает тег экземпляра класса
     * @return string
     */

    public function setItemTag()
    {

        $key = $this->getItemTagName();

        Yii::$app->cache->set($key, microtime(true));

        return $key;

    }

    /**
     * Возвращает тег экземпляра класса
     * @return string
     */

    public function getItemTagName()
    {

        return $this->getClassTagName() . "_" . $this->owner->id;

    }

    /**
     * Возвращает тег для класса
     * @return string
     */

    public function getClassTagName()
    {

        return static::PREFFIX . get_class($this->owner);

    }

    /**
     * Вызывается после добавления или удаления модели
     */

    public function afterInsertOrDelete()
    {

        $this->setClassTag();

    }

    /**
     * Устанавливает тег класса
     * @return string
     */

    public function setClassTag()
    {

        $key = $this->getClassTagName();

        Yii::$app->cache->set($key, microtime(true));

        return $key;

    }

    /**
     * @inheritdoc
     */

    public function events()
    {

        return [

            ActiveRecord::EVENT_AFTER_UPDATE => [$this, "afterUpdate"],
            ActiveRecord::EVENT_AFTER_DELETE => [$this, "afterInsertOrDelete"],
            ActiveRecord::EVENT_AFTER_INSERT => [$this, "afterInsertOrDelete"],

        ];

    }

}