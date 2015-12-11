<?php

namespace common\inputs;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\rating\StarRating;

/**
 * Class RatingInput
 * @package common\inputs
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class RatingInput extends BaseInput
{

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


		return $form->field($this->modelField->model, $this->getFormAttrName($index, $this->modelField->attr))->widget(StarRating::className(), $widgetOptions);
	}

}