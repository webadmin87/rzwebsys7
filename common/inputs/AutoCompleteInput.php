<?php

namespace common\inputs;

use common\widgets\AutoComplete;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class AutoCompleteInput
 * Поле с автозаполнением
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AutoCompleteInput extends BaseInput {

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

        $widgetOptions = ArrayHelper::merge(["visibleOptions"=>["class"=>"form-control"]], $this->widgetOptions, ["options"=>$options]);

        $attr = $this->getFormAttrName($index, $this->modelField->attr);

        return $form->field($this->modelField->model, $attr)->widget(AutoComplete::className(), $widgetOptions);
    }


} 