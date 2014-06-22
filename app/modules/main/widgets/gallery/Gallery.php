<?php
namespace app\modules\main\widgets\gallery;

use common\widgets\App;

/**
 * Class Gallery
 * Виджет для вывода фотогаллереи
 * @package app\modules\main\widgets\gallery
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Gallery extends App {

    /**
     * @var \common\core\File[] массив файлов
     */

    public $files = [];

    /**
     * @var int количество фото пропущенных сначала
     */

    public $skipFromStart = 0;

    /**
     * @var int ширина фото
     */

    public $width = 150;

    /**
     * @var int высота фото
     */

    public $height = 150;

    /**
     * @var array массив html атрибутов тега обертки
     */

    public $options = [];

    /**
     * @inheritdoc
     */

    public function init() {

        if($this->skipFromStart>0) {

            array_splice($this->files, 0, $this->skipFromStart);

        }

    }

    /**
     * @inheritdoc
     */

    public function run() {

        if(!$this->isShow() OR empty($this->files))
            return false;

        return $this->render($this->tpl,[
            "files"=>$this->files,
            "width"=>$this->width,
            "height"=>$this->height,
            "options"=>$this->options,
        ]);

    }


}