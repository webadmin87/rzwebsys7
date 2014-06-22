<?php
namespace app\modules\main\widgets\elist;

use Yii;
use common\widgets\App;

/**
 * Class EList
 * Виджет для вывода элементов. Отображаемая сущность должна наследовать \common\db\ActiveRecord
 * @package app\modules\main\widgets\treelist
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class EList extends App {

    /**
     * @var string имя класса модели
     */
    public $modelClass;

    /**
     * @var int количество выводимых элементов
     */

    public $limit = 3;

    /**
     * @var array сортировка элементов
     */

    public $order = ['id'=>'DESC'];

    /**
     * @var closure функция возвращающая url модели. Принимает аргументом модель для которой необходимо создать url
     */
    public $urlCreate;

    /**
     * @var closure функция для модификации запроса. Принимает аргументом \common\db\TActiveQuery
     */
    public $queryModify;

    /**
     * @var array массив атрибутов html тега
     */

    public $options = array();

    /**
     * @var array массив моделей
     */
    protected $models;

    /**
     * @var int глубина родительского раздела
     */

    protected $parentLevel;

    /**
     * @inheritdoc
     */

    public function init() {

        if(!$this->isShow())
            return false;

        $class = $this->modelClass;

        $query = $class::find()->published()->orderBy($this->order)->limit($this->limit);

        if(is_callable($this->queryModify)) {

            $func = $this->queryModify;

            $func($query);

        }

        $this->models = $query->all();

    }


    /**
     * @inheritdoc
     */

    public function run() {

        if(!$this->isShow() OR empty($this->models))
            return false;

        return $this->render($this->tpl,[
            "models"=>$this->models,
            "options"=>$this->options,
            "urlCreate"=>$this->urlCreate,
        ]);

    }

}