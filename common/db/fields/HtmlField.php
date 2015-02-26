<?php

namespace common\db\fields;

/**
 * Class HtmlField
 * Поле WYSIWYG редактора. Использует CKEditor
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HtmlField extends TextAreaField
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\HtmlInput";

}