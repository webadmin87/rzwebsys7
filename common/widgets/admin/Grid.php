<?php
namespace common\widgets\admin;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class Grid
 * Грид для админки. Формируется на основе \common\db\MetaFields модели
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Grid extends Widget {

    /**
     * Преффикс идентификатора грида
     */

    const GRID_ID_PREF = "grid-";

    /**
     * @var \common\db\ActiveRecord модель
     */

    public $model;

    /**
     * @var \yii\data\ActiveDataProvider провайдер данных
     */

    public $dataProvider;

    /**
     * @var array кнопки строк грида
     */

    public $rowButtons = [];

    /**
     * @var array кнопки групповых операций
     */

    protected $groupButtons;

    /**
     * @var string идентификатор виджета
     */

    protected $id;

    /**
     * @var string шаблон
     */

    public $tpl = "grid";

    public function init() {

        $model = $this->model;

        $this->id = strtolower(self::GRID_ID_PREF.str_replace("\\", "-", $model::className()));

    }

    /**
     * Установка кнопок групповых операций
     * @param array $buttons описание кнопок, имеет следующий вид
     * [
     *  "delete"=>[
     *      "title"=>"Delete",
     *      "options"=>[
     *           "id"=>"group-delete",
     *           "class"=>"btn btn-danger btn-xs",
     *      ],
     *      "url"=>"groupdelete"
     *  ],
     * ]
     */
    public function setGroupButtons(Array $buttons) {

        $this->$groupButtons = ArrayHelper::merge($this->defaultGroupButtons(), $buttons);

    }

    /**
     * Возвращает массив кнопок групповых операций
     * @return array
     */

    public function getGroupButtons() {

        if($this->groupButtons !== null) {
            return $this->$groupButtons;
        } else {
            return $this->defaultGroupButtons();
        }

    }

    /**
     * Кнопки групповых операций по умолчанию
     * @return array
     */

    protected function defaultGroupButtons() {

        return [

            "delete" => [

                "title"=>Yii::t('core', 'Delete'),
                "options" => [
                    'id'=>'group-delete',
                    'class'=>'btn btn-danger btn-xs',
                ],
                "url"=>"groupdelete",
            ],

        ];

    }

    /**
     * Возвращает описание колонок
     * @return array
     */

    protected function getColumns() {

        $columns = [

            ['class' => 'yii\grid\CheckboxColumn'],
            'id',

        ];

        $fields = $this->model->getMetaFields()->getFields();

        foreach($fields AS $field) {

            $grid = $field->grid();

            if($field->showInGrid AND $grid)
                $columns[] = $grid;

        }

        $columns[] = array_merge(['class' => 'yii\grid\ActionColumn'], $this->rowButtons);

        return $columns;

    }

    /**
     * Запуск виджета
     * @return string|void
     */

    public function run() {

       return $this->render($this->tpl, [
           "model"=>$this->model,
           "dataProvider"=>$this->dataProvider,
           "columns"=>$this->getColumns(),
           "groupButtons"=>$this->getGroupButtons(),
           "id"=>$this->id,
       ]);

    }




}