<?php
namespace common\db\fields;

/**
 * Class HasOneField
 * Поле для связей Has One. Интерфейс привязки в форме в виде radio button.
 * @package common\db\fields
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class HasOneRadioField extends HasOneField
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\RadioListInput";


}