<?php
namespace common\behaviors;

use Yii;

/**
 * Class Html5UploadBehavior
 * Поведение для загрузки файлов через html5 виджет через ajax
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Html5UploadBehavior extends UploadBehavior
{

    /**
     * Перед сохранением модели серилизуем массив с описанием файлов
     * @return bool
     */

    public function beforeSave()
    {

        $this->deleteFiles();

        $attr = $this->attribute;

        if (is_array($this->owner->$attr)) {

            $arr = $this->owner->$attr;

            foreach ($arr AS $k => $v) {

                if (empty($v["file"]))
                    unset($arr[$k]);

            }

            $this->owner->$attr = !empty($arr) ? serialize($arr) : "";

        } else {
            $this->owner->$attr = "";
        }

        return true;
    }

}