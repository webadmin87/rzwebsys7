<?php

namespace common\inputs;

use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/**
 * Class DateInput
 * Поле ввода даты
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DateInput extends BaseInput {

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

        $widgetOptions = ArrayHelper::merge(["options"=>["class" => "form-control"]], $this->widgetOptions, ["options"=>$options]);

        return $form->field($this->modelField->model, $this->getFormAttrName($index, $this->modelField->attr))->widget(DatePicker::className(), $widgetOptions);
    }


} 