<?php

namespace common\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\InvalidConfigException;

/**
 * Class DependDropDown
 * Виджет для организации зависимых списков
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DependDropDown extends InputWidget
{

	/**
	 * @var array маршрут для подгрузки зависимого списка
	 */
	public $source;

	/**
	 * @var string имя зависимого атрибута модели. используется если в виджет передана модель
	 */
	public $dependAttr;

	/**
	 * @var string jQuery селектор зависимого списка. используется если модель отсутствует
	 */
	public $dependSelector;

	/**
	 * @var bool генерировать событие change на элементе при его загрузке в структуру документа
	 */
	public $triggerChange = false;

	/**
	 * @var array массив значений зависмого списка ($key=>$value)
	 */
	public $data = [];

	/**
	 * @var string имя атрибута передаваемого на сервер
	 */
	public $serverAttr = "id";

	/**
	 * @inheritdoc
	 * @throws InvalidConfigException
	 */
	public function init()
	{

		parent::init();

		if (empty($this->dependAttr) AND empty($this->dependSelector))
			return;

		if ($this->hasModel() AND empty($this->dependSelector)) {

			$dependSelector = "#" . Html::getInputId($this->model, $this->dependAttr);

		} else {

			$dependSelector = $this->dependSelector;

		}

		$url = Url::toRoute($this->source);

		$this->view->registerJs("

			$('#{$this->options["id"]}').on('change', function(){

				var val = $(this).val();
				var inp = $('$dependSelector');

				if(!val) {
					inp.html('');
					return;
				}

				$.get('$url', {'{$this->serverAttr}': val}, function(data){

					inp.html(data);
					inp.val(inp.prev().val()).trigger('change');

				});

			});

		");

		if($this->triggerChange) {

			$this->view->registerJs("

				$('#{$this->options["id"]}').trigger('change');

			");

		}

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		if ($this->hasModel()) {
			$html = Html::activeHiddenInput($this->model, $this->attribute, ["id"=>null]);
			$html .= Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
		} else {
			$html = Html::hiddenInput($this->name, $this->value, ["id"=>null]);
			$html .= Html::dropDownList($this->name, $this->value, $this->options);
		}

		return $html;
	}

}