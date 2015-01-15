<?php
namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class TagCache
 * Поведение тегированного кеширования
 * @package common\behaviors
 * @property \common\db\ActiveRecord $owner
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TagCache extends Behavior
{

    /**
     * @var string атрибут хранящий признак активности элемента
     */
    public $activeAttribute = "active";

    const PREFFIX = "tag_cache_";

    /**
     * Вызывается после изменения модели
     */

    public function beforeUpdate()
    {

        $this->setItemTag();

        if($this->owner->hasChangeActive())
        {
            $this->setClassTag();
        }

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
     * Устанавливает тег экземпляра класса если он еще не установлен
     * @return string
     */
    public function setItemTagSafe()
    {

        $key = $this->getItemTagName();

        $val = Yii::$app->cache->get($key);

        if($val === false) {

            Yii::$app->cache->set($key, microtime(true));

        }

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
     * Устанавливает тег класса, если он еще не установлен
     * @return string
     */

    public function setClassTagSafe()
    {

        $key = $this->getClassTagName();

        $val = Yii::$app->cache->get($key);

        if($val === false) {

            Yii::$app->cache->set($key, microtime(true));

        }

        return $key;

    }

    /**
     * @inheritdoc
     */

    public function events()
    {

        return [

            ActiveRecord::EVENT_BEFORE_UPDATE => [$this, "beforeUpdate"],
            ActiveRecord::EVENT_AFTER_DELETE => [$this, "afterInsertOrDelete"],
            ActiveRecord::EVENT_AFTER_INSERT => [$this, "afterInsertOrDelete"],

        ];

    }

}