<?php
namespace common\db\fields;

/**
 * Class AutoCompleteField
 * Поле с автозаполнением.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AutoCompleteField extends Field
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\AutoCompleteInput";


}