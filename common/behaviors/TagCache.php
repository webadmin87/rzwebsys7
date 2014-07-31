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
class TagCache extends Behavior {


    const PREFFIX = "tag_cache_";

    /**
     * Возвращает тег для класса
     * @return string
     */

    public function getClassTagName() {

        return static::PREFFIX . get_class($this->owner);

    }

    /**
     * Возвращает тег экземпляра класса
     * @return string
     */

    public function getItemTagName() {

        return $this->getClassTagName() . "_" . $this->owner->id;

    }

    /**
     * Устанавливает тег класса
     * @return string
     */

    public function setClassTag() {

        $key = $this->getClassTagName();

        Yii::$app->cache->set($key, microtime(true));

        return $key;

    }

    /**
     * Устанавливает тег экземпляра класса
     * @return string
     */

    public function setItemTag() {

        $key = $this->getItemTagName();

        Yii::$app->cache->set($key, microtime(true));

        return $key;

    }


    /**
     * Вызывается после изменения модели
     */

    public function afterUpdate() {

        $this->setItemTag();

    }

    /**
     * Вызывается после добавления или удаления модели
     */

    public function afterInsertOrDelete() {

        $this->setClassTag();

    }

    /**
     * @inheritdoc
     */

    public function events() {

        return [

            ActiveRecord::EVENT_AFTER_UPDATE => [$this, "afterUpdate"],
            ActiveRecord::EVENT_AFTER_DELETE => [$this, "afterInsertOrDelete"],
            ActiveRecord::EVENT_AFTER_INSERT => [$this, "afterInsertOrDelete"],

        ];

    }


}