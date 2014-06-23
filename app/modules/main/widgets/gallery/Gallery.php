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

    const DEFAULT_REL_PREF = "rel-";

    const DEFAULT_CLASS = "yii-gallery";

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
     * @var bool подключать ли ассет виджета
     */

    public $registerAsset = true;

    /**
     * @var string атрибут rel фотогаллереи
     */

    protected $_rel;

    /**
     * @inheritdoc
     */

    public function init() {

        if(!$this->isShow())
            return false;

        if($this->registerAsset)
            AssetBundle::register($this->view);

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
            "options"=>array_merge(["class"=>self::DEFAULT_CLASS], $this->options),
            "rel"=>$this->rel,
        ]);

    }

    /**
     * Установка атрибута rel
     * @param string $rel
     */

    public function setRel($rel) {

        $this->_rel = $rel;
    }

    /**
     * Получение значения атрибута rel
     * @return string
     */

    public function getRel() {

        if($this->_rel === null)
            $this->_rel = self::DEFAULT_REL_PREF.$this->id;

        return $this->_rel;

    }

}