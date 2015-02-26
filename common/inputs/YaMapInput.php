<?php

namespace common\inputs;

use yii\helpers\ArrayHelper;
use common\widgets\yamap\YaMapInput as Widget;
use yii\widgets\ActiveForm;

/**
 * Class YaMapInput
 * Поле выбора координат на яндекс карте
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapInput extends BaseInput {

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

        return $form->field($this->modelField->model, $this->getFormAttrName($index, $this->modelField->attr))->widget(Widget::className(), $widgetOptions);
    }


} 