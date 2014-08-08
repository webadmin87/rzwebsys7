<?php
namespace common\db\fields;

use yii\helpers\ArrayHelper;

/**
 * Class HiddenField
 * Скрытое поле модели.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HiddenField extends Field
{

	/**
	 * @var bool отображать в фильтре грида
	 */
	public $showInFilter = false;

	/**
	 * @var bool отображать в расширенном фильре
	 */
	public $showInExtendedFilter = false;

	/**
	 * @var bool отображать поле при табличном вводе
	 */
	public $showInTableInput = false;

    /**
     * @inheritdoc
     */
	public function form(ActiveForm $form, Array $options = [], $index = false)
	{

		$options = ArrayHelper::merge($this->options, $options);

		return $form->field($this->model, $this->getFormAttrName($index))->hiddenInput($options);

	}
}