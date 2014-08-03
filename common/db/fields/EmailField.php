<?php
namespace common\db\fields;

/**
 * Class EmailField
 * Поле ввода Email
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class EmailField extends TextField
{

    /**
     * Правила валидации
     * @return array
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'email'];

        return $rules;

    }

}