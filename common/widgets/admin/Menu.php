<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\bootstrap\Nav;

/**
 * Class Menu
 * Виджет для формирования меню админки на основе настроек модулей
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Menu extends Widget {

    /**
     * @var array html атрибуты для меню
     */

    public $options = [];

    /**
     * @var string идентификатор административного модуля
     */

    public $adminId = "admin";

    /**
     * @var array описание пунктов меню для виджета \yii\bootstrap\Nav
     * @link http://www.yiiframework.com/doc-2.0/yii-bootstrap-nav.html
     */

    protected $items = [];

    /**
     * @inheritdoc
     */

    public function init() {

        $modules = Yii::$app->modules;

        foreach($modules AS $module) {

           if(is_object($module)) {

               $admin = $module->getModule($this->adminId);

               // @tofix сделать проверку прав при формировании меню

               if($admin AND is_callable($admin->menuItems)) {

                   $func = $admin->menuItems;

                   $this->items = array_merge($this->items, $func());

               }

           }

        }

    }

    /**
     * @inheritdoc
     */

    public function run() {


        return Nav::widget([
            'route'=>Yii::$app->controller->uniqueId,
            'items' => $this->items,
            'options' => array_merge([
                'class'=>'nav nav-pills nav-stacked'
            ], $this->options)
        ]);


    }


}