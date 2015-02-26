<?php
namespace common\db\fields;

/**
 * Class DateField
 * Поле ввода даты
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DateField extends TextField
{

    /**
     * @var string формат даты
     */
    public $dateFormat = 'yyyy-MM-dd';

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\DateInput";


    /**
     * @inheritdoc
     */
    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'date', 'format' => $this->dateFormat];

        return $rules;

    }

}