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

    /**
     * @inheritdoc
     */
    public function grid()
    {

        $grid = parent::grid();

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
     * @inheritdoc
     */
    public function view()
    {

        $view = parent::view();

        $view["value"] = $this->getStringValue($this->model);

        return $view;

    }

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

        $data = $this->getDataValue();

        if (empty($data))
            return false;

        $options["multiple"] = true;

        return $form->field($this->model, $this->getFormAttrName($index))->widget(\dosamigos\multiselect\MultiSelect::className(),
            [
                "data" => $data,
                "options" => ["multiple" => true]
            ]
        );

    }

    /**
     * @inheritdoc
     */

    public function xEditable()
    {
        return false;
    }

    /**
     * @inheritdoc
     */

    public function search(ActiveQuery $query)
    {

        $table = $this->model->tableName();

        $relatedClass = $this->model->{"get" . ucfirst($this->relation)}()->modelClass;

        $tableRelated = $relatedClass::tableName();

        if ($this->search)
            $query->
            joinWith($this->relation, true)->
            andFilterWhere(["$tableRelated.id" => $this->model->{$this->attr}])->
            groupBy("$table.id");

    }

}