<?php
namespace common\widgets\admin;

use yii\base\Widget;


/**
 * Class Grid
 * Грид для админки. Формируется на основе \common\db\MetaFields модели
 * @package common\widgets\admin
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Grid extends Widget {

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

    public $groupButtons = [];

    /**
     * @var string шаблон
     */

    public $view = "grid";

    /**
     * Возвращает описание колонок
     * @return array
     */

    protected function getColumns() {

        $columns = [

            ['class' => 'yii\grid\SerialColumn'],
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

       return $this->render($this->view, [
           "model"=>$this->model,
           "dataProvider"=>$this->dataProvider,
           "columns"=>$this->getColumns(),
       ]);

    }




}