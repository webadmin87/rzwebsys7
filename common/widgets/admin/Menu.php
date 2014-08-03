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
class Menu extends Widget
{

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
     * Также добавлен элеиент с ключом permission. Представляет собой массив первый элемент которого имя права доступа, второй массив параметров для проверки.
     * "permission"=>["listModels", ["model"=>Yii::createObject(models\User::className())]]
     */

    protected $items = [];

    /**
     * @inheritdoc
     */

    public function init()
    {

        $modules = Yii::$app->modules;

        foreach ($modules AS $code => $value) {

            $module = Yii::$app->getModule($code);

            if (is_object($module)) {

                $admin = $module->getModule($this->adminId);

                if ($admin AND is_callable($admin->menuItems)) {

                    $this->items = array_merge($this->items, call_user_func($admin->menuItems));

                    $this->processAccess();

                }

            }

        }

    }

    /**
     * Ограничение прав доступа к пунктам меню
     */

    public function processAccess()
    {

        if (Yii::$app->user->can("rootAccess"))
            return;

        $arr = [];

        foreach ($this->items AS $moduleItem) {

            if (empty($moduleItem["items"]))
                continue;

            foreach ($moduleItem["items"] AS $k => $item) {
                $permission = $item["permission"][0];

                $params = isset($item["permission"][1]) ? $item["permission"][1] : [];

                if (!isset($item["permission"]) OR !Yii::$app->user->can($permission, $params))
                    unset($moduleItem["items"][$k]);

            }

            if (!empty($moduleItem["items"]))
                $arr[] = $moduleItem;

        }

        $this->items = $arr;

    }

    /**
     * @inheritdoc
     */

    public function run()
    {

        return Nav::widget([
            'route' => Yii::$app->controller->uniqueId,
            'items' => $this->items,
            'options' => array_merge([
                'class' => 'nav nav-pills nav-stacked'
            ], $this->options)
        ]);

    }

}