<?php

namespace common\inputs;

use dosamigos\multiselect\MultiSelect;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class MultiSelectInput
 * Список множественного выбора
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class MultiSelectInput extends BaseInput {

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @param bool|int $index инднкс модели при табличном вводе
     * @return string
     */
    public function renderInput(ActiveForm $form, Array $options = [], $index = false)
    {
        $data = $this->modelField->getDataValue();

        if(empty($data))
            return false;

        $options = ArrayHelper::merge($this->options, $options, ["multiple"=>true]);

        $widgetOptions = ArrayHelper::merge(["data"=>$data], $this->widgetOptions, ["options"=>$options]);

        $attr = $this->getFormAttrName($index, $this->modelField->attr);

        return $form->field($this->modelField->model, $attr)->widget(MultiSelect::className(), $widgetOptions);
    }


} 