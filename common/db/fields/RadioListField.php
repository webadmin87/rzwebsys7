<?php
namespace common\db\fields;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * Class RadioListField
 * Поле для связей Has One. Интерфейс привязки в форме в виде radiobutton.
 * @package common\db\fields
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */

class RadioListField extends ListField {

	/**
	 * @inheritdoc
	 */

	public function getForm(ActiveForm $form, Array $options = [], $index = false)
	{

		$options = ArrayHelper::merge($this->options, $options);

		$widgetOptions = ArrayHelper::merge($options, $this->widgetOptions);

		return $form->field($this->model, $this->getFormAttrName($index))->radioList($this->getDataValue(), $widgetOptions);

	}

}