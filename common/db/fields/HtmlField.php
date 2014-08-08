<?php

namespace common\db\fields;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class HtmlField
 * Поле WYSIWYG редактора. Использует CKEditor
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HtmlField extends TextAreaField
{

    /**
     * @var array настройки редактора
     */

    public $editorOptions = [];

    /**
     * @var string контроллер файлового менеджера
     */

    public $fileManagerController = "elfinder";

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

		$options = ArrayHelper::merge($this->options, $options);

        $editorOptions = ArrayHelper::merge([
            'preset' => 'full',
            'inline' => false,
            'allowedContent' => true,
        ], $this->editorOptions);

        $ckeditorOptions = ElFinder::ckeditorOptions($this->fileManagerController, $editorOptions);

        return $form->field($this->model, $this->getFormAttrName($index))->widget(CKEditor::className(), [
			'options'=> $options,
            'editorOptions' => $ckeditorOptions,
        ]);;

    }

}