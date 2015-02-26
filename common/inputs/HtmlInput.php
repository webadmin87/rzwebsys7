<?php

namespace common\inputs;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class HtmlInput
 * Html поле
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HtmlInput extends BaseInput {

    /**
     * @var string контроллер файлового менеджера
     */

    public $fileManagerController = "elfinder";

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @param bool|int $index инднкс модели при табличном вводе
     * @return string
     */
    public function renderInput(ActiveForm $form, Array $options = [], $index = false)
    {

        $options = ArrayHelper::merge($this->options, $options);

        $editorOptions = [
            'preset' => 'full',
            'inline' => false,
            'allowedContent' => true,
            'autoParagraph' => false,
        ];

        $ckeditorOptions = ElFinder::ckeditorOptions($this->fileManagerController, $editorOptions);

        $widgetOptions = ArrayHelper::merge([
            "editorOptions"=>$ckeditorOptions
        ], $this->widgetOptions, ['options'=> $options]);

        $attr = $this->modelField->attr;

        return $form->field($this->modelField->model, $this->getFormAttrName($index, $attr))->widget(CKEditor::className(), $widgetOptions);


    }


} 