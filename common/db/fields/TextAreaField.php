<?php
namespace common\db\fields;

/**
 * Class TextAreaField
 * Поле текстовой области модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class TextAreaField extends TextField {

    /**
     * @var bool отображать в гриде
     */
    public $showInGrid = false;

    /**
     * @var bool отображать в фильтре грида
     */
    public $showInFilter = false;

    /**
     * @var bool отображать в расширенном фильре
     */
    public $showInExtendedFilter = false;

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function form(ActiveForm $form, Array $options = []) {

        return $form->field($this->$model, $this->attr)->textarea($options);

    }

}