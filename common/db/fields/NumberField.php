<?php
namespace common\db\fields;

/**
 * Class NumberField
 * Поле ввода чисел
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NumberField extends TextField {


    /**
     * Правила валидации
     * @return array
     */

    public function rules() {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'number'];

        return $rules;

    }


}