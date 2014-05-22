<?php
namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
/**
 * Class Html5UploadBehavior
 * Поведение для загрузки файлов через html5 виджет
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Html5UploadBehavior extends UploadBehavior {

    /**
     * @var array предыдущее значение атрибута модели хранящего информацию о прицепленных файлах. Устанавливается в afterFind.
     */

    protected $_value = array();

    /**
     * @inheritdoc
     */

    public function  events() {

        $events = [

            ActiveRecord::EVENT_BEFORE_INSERT => "beforeSave",
            ActiveRecord::EVENT_BEFORE_UPDATE => "beforeSave",
            ActiveRecord::EVENT_AFTER_INSERT => "afterSave",
            ActiveRecord::EVENT_AFTER_UPDATE => "afterSave",
            ActiveRecord::EVENT_AFTER_FIND => "afterFind",
            ActiveRecord::EVENT_BEFORE_DELETE => "beforeDelete",
        ];

        return array_merge(parent::events(), $events);

    }


    /**
     * Перед сохранением модели
     * @return bool
     */

    public function beforeSave()
    {

        $this->deleteFiles();

        $attr = $this->attribute;

        if (is_array($this->owner->$attr)) {

            $arr = $this->owner->$attr;

            foreach($arr AS $k=>$v) {

                if(empty($v["file"]))
                    unset($arr[$k]);

            }


            $this->owner->$attr = !empty($arr)?serialize($arr):"";

        } else {
            $this->owner->$attr = "";
        }

        return true;
    }

    /**
     * После сохранения модели
     * @return bool
     */

    public function afterSave()
    {

        $attr = $this->attribute;

        if (!empty($this->owner->$attr))
            $this->owner->$attr = unserialize($this->owner->$attr);

        return true;
    }

    /**
     * После выборки модели
     * @return bool
     */

    public function afterFind()
    {

        $attr = $this->attribute;

        if (!empty($this->owner->$attr)) {

            $arr = unserialize($this->owner->$attr);
            $this->owner->$attr = $arr;
            $this->_value = $arr;

        }
        return true;
    }


    /**
     * Перед удалением модели
     * @return bool
     */

    public function beforeDelete() {
        $this->deleteAllFiles(); // удалили модель, удаляем и файл от неё
        return true;
    }


    /**
     * Удаляет файлы перед сохранением
     * @return bool
     */

    protected function deleteFiles() {

        if(!is_array($this->_value))
            return false;

        foreach($this->_value AS $v) {

            $path = Yii::getAlias($this->webroot) . $v["file"];

            if(!$this->hasFile($v["file"]) AND is_file($path))
                unlink($path);

        }

        return true;

    }



}