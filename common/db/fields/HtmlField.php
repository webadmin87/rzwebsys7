<?php

namespace common\db\fields;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;

/**
 * Class HtmlField
 * Поле WYSIWYG редактора. Использует CKEditor
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class HtmlField extends TextAreaField {

    /**
     * @var array настройки редактора
     */

    public $editorOptions = [];

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = []) {

        $options = ArrayHelper::merge([
            'preset' => 'full',
            'inline' => false,
        ], $this->editorOptions);

        return $form->field($this->model, $this->attr)->widget(CKEditor::className(),[
            'editorOptions' => $options,
        ]);;

    }


}