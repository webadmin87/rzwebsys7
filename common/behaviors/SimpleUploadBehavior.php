<?php

namespace common\behaviors;

/**
 * Class SimpleUploadBehavior
 * Загрузка файлов отправленных с формой
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class SimpleUploadBehavior extends UploadBehavior {

    /**
     * Обработка загрузки файлов
     */

    function beforeSave()
    {

        $attr = $this->attribute;

        $this->owner->$attr = is_array($this->owner->$attr)?$this->owner->$attr:array();

        $fileNames = $this->getFilesArr( $this->uploadFiles($attr) );

        $fileNames = array_merge($this->owner->$attr, $fileNames);

        $this->owner->$attr = !empty($fileNames)?serialize($fileNames):'';

        return true;

    }


}