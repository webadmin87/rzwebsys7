<?php

namespace common\inputs;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/**
 * Class DateRangeInput
 * Поле ввода диапазона дат
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DateRangeInput extends BaseInput {

    /**
     * @var string атрибут от
     */
    public $fromAttr;

    /**
     * @var string атрибут до
     */
    public $toAttr;

    public function init()
    {
        parent::init();

        if(empty($this->fromAttr) || empty($this->toAttr)) {

            throw new InvalidConfigException("Properties 'fromAttr', 'toAttr' can`t be blank");
        }

    }


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

        $fieldOptions = [

            "options"=>["class"=>"form-group col-xs-6"],

        ];

        $html = Html::beginTag('div', ['class'=>'row']);
        $html .= $form->field($this->modelField->model, $this->fromAttr, $fieldOptions)->widget(DatePicker::className(), $widgetOptions);
        $html .= $form->field($this->modelField->model, $this->toAttr, $fieldOptions)->widget(DatePicker::className(), $widgetOptions);
        $html .= Html::endTag('div');

        return $html;
    }


} 