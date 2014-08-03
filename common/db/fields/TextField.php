<?php
namespace common\db\fields;

/**
 * Class TextField
 * Текстовое поле модели.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TextField extends Field
{

    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'filter', 'filter' => 'trim'];

        return $rules;

    }

}