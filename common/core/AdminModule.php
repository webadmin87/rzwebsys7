<?php
namespace common\core;

use yii\base\Module;

/**
 * Class AdminModule
 * Базовый класс для административных модулей
 * @package common\core
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class AdminModule extends Module {

    /**
     * @var closure анонимная функция возвращающая меню для админки.
     * Для формирования меню используется виджет \yii\bootstrap\Nav
     * @link http://www.yiiframework.com/doc-2.0/yii-bootstrap-nav.html
     */

    public $menuItems;

}