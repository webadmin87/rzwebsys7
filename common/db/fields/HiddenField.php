<?php
namespace common\db\fields;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

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
	public $inputClass = "\\common\\inputs\\HiddenInput";
}