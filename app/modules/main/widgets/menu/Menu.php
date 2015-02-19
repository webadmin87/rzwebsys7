<?php
namespace app\modules\main\widgets\menu;

use app\modules\main\models\Menu as MenuModel;
use common\widgets\App;

/**
 * Class Menu
 * Виджет мен.
 * @package app\modules\main\widgets\menu
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Menu extends App
{

    /**
     * @var int идентификатор родительского пункта меню
     */
    public $parentId;

    /**
     * @var string символьный идентификатор родительского пункта меню
     */
    public $parentCode;

    /**
     * @var string ссылка родительского пункта, если указана используем как корневой раздел.
     * Поиск по ссылке родитльского пункта осуществляется среди прямых потомков модели найденной по свойству $parentId
     */

    public $parentLink;

    /**
     * @var int уровень вложенности
     */
    public $level = 1;

    /**
     * @var array html - атрибуты корневого тега ul меню
     */

    public $options = array();

    /**
     * @var string имя класса активного пункта меню
     */

    public $actClass = "active";

    /**
     * @var Menu[] массив моделей меню
     */

    protected $models = array();

    /**
     * @var int уровень вложенности родительского пункта меню
     */

    protected $parentLevel;

    /**
     * @inheritdoc
     * Инициализация
     */

    public function init()
    {

        if (!$this->isShow())
            return false;

        $this->findModels();

    }

    /**
     * Поиск моделей меню
     * @return bool
     */

    protected function findModels()
    {

        $parentQuery = MenuModel::find()->published();

        if ($this->parentId)
            $parent = $parentQuery->where(["id" => $this->parentId])->one();
        elseif ($this->parentCode)
            $parent = $parentQuery->where(["code" => $this->parentCode])->one();

        if (empty($parent))
            return false;

        if (!empty($this->parentLink)) {

            $parent = $parent->children()->published()->where(["link" => $this->parentLink])->one();

            if (!$parent)
                return false;

        }

        $this->parentLevel = $parent->level;

        $level = $parent->level + $this->level;

        $this->models = $parent->children()->published()->andWhere("level <= :level", [":level" => $level])->all();

        return true;

    }

    /**
     * @inheritdoc
     * Запуск виджета
     */

    public function run()
    {

        if (!$this->isShow() OR empty($this->models))
            return false;

        return $this->render($this->tpl, [
            "models" => $this->models,
            "parentLevel" => $this->parentLevel,
            "options" => $this->options,
            "actClass" => $this->actClass,
        ]);

    }

}