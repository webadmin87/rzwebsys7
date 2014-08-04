<?php
namespace app\modules\main\components;

use yii\base\Object;

/**
 * Class BlocksProvider
 * Провайдер символьных идентификаторов меню и включаемых областей.
 * Предоставляет интерфейс для того чтобы сопоставить место блока в шаблоне сайта и
 * символьный идентификатор включаемой области или меню. Это необходимо для того, чтобы компоненты сайта могли динамичеки
 * переопределять подключаемы области.
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BlocksProvider extends Object
{

    /**
     * @var array массив сопоставлений для меню
     */
    public $menus = [];

    /**
     * @var array массив сопоставлений для включаемых областей
     */
    public $areas = [];

    /**
     * Устанавливает соответствие для меню
     * @param string $placeCode код места
     * @param string $menuCode символьный код меню
     */
    public function setMenu($placeCode, $menuCode) {

        $this->menus[$placeCode] = $menuCode;

    }

    /**
     * Возвращает символьный код меню для места
     * @param string $placeCode код места
     * @param string|null $default значение по умолчанию
     * @return string|null
     */
    public function getMenu($placeCode, $default = null) {

        return isset($this->menus[$placeCode])?$this->menus[$placeCode]:$default;

    }

    /**
     * @param string $placeCode код места
     * @param string $areaCode символьный код включаемой области
     */
    public function setArea($placeCode, $areaCode) {

        $this->menus[$placeCode] = $areaCode;

    }

    /**
     * Возвращает символьный код включаемой области для места
     * @param string $placeCode код места
     * @param string|null $default значение по умолчанию
     * @return string|null
     */
    public function getArea($placeCode, $default = null) {

        return isset($this->areas[$placeCode])?$this->menus[$placeCode]:$default;

    }


}