<?php
namespace common\db\fields;

use common\db\ActiveQuery;
use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class ManyManyField
 * Поле для связей Many Many
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ManyManyField extends HasOneField
{

    public $eagerLoading = true;

    public $numeric = false;

    public $checkExist = false;

    public $inputClass = "\\common\\inputs\\MultiSelectInput";

    /**
     * Отображение в гриде
     */
    protected function grid()
    {

        $grid = $this->defaultGrid();

        $grid["value"] = function ($model, $index, $widget) {

            return $this->getStringValue($model);

        };

        return $grid;

    }

    /**
     * Возвращает строковое представление связанных моделей для отображения в гриде и при детальном просмотре
     * @param ActiveRecord $model
     * @return string
     */

    protected function getStringValue($model)
    {

        $relatedAll = $model->{$this->relation};

        $arr = [];

        foreach ($relatedAll AS $related) {

            $arr[] = ArrayHelper::getValue($related, $this->gridAttr);

        }

        return implode(",", $arr);

    }

    /**
     * Отображение при детальном просмотре
     */
    protected function view()
    {

        $view = $this->defaultView();

        $view["value"] = $this->getStringValue($this->model);

        return $view;

    }

    /**
     * Редактирование в гриде
     */

    public function xEditable()
    {
        return false;
    }

    /**
     * Поиск
     * @param ActiveQuery $query
     */
    protected function search(ActiveQuery $query)
    {

        $table = $this->model->tableName();

        $relatedClass = $this->model->{"get" . ucfirst($this->relation)}()->modelClass;

        $tableRelated = $relatedClass::tableName();

        $query->
        joinWith($this->relation, $this->eagerLoading)->
        andFilterWhere(["{{%$tableRelated}}.{{%id}}" => $this->model->{$this->attr}])->
        groupBy("$table.id");

    }



}