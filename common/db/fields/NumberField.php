<?php
namespace common\db\fields;

/**
 * Class NumberField
 * Поле ввода чисел
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NumberField extends TextField
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\NumberInput";

    /**
     * Правила валидации
     * @return array
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'number'];

        return $rules;

    }

    /**
     * @inheritdoc
     */
    protected function grid()
    {

        $grid = $this->defaultGrid();

        $grid["format"] = "decimal";

        return $grid;

    }

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = $this->defaultView();

        $view['format'] = 'decimal';

        return $view;

    }

}