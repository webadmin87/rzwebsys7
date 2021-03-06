<?php

namespace common\inputs;

use common\widgets\DependDropDown;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class RadioListInput
 * Список radio переключателей
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class RadioListInput extends BaseInput {

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

        $attr = $this->modelField->attr;

        return $form->field($this->modelField->model, $this->getFormAttrName($index, $attr), $this->widgetOptions)->radioList($this->modelField->getDataValue(), $options);
    }


} 