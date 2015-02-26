<?php

namespace common\inputs;

use common\widgets\SortedTags;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class SortedTagsInput
 * Список тегов с возможностью сортировки
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SortedTagsInput extends BaseInput {

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

        $options = ArrayHelper::merge(["class"=>"form-control"], $this->options, $options, ["multiple"=>true]);

        $widgetOptions = ArrayHelper::merge([
            "items" => $data,
            "bootstrap"=>true,
            "settings" => [
                    "tokenSeparators" => [',', ' '],
                ]
            ], $this->widgetOptions, ["options"=>$options]);

        $attr = $this->getFormAttrName($index, $this->modelField->attr);

        return $form->field($this->modelField->model, $attr)->widget(SortedTags::className(), $widgetOptions);
    }


} 