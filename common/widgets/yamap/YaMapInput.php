<?php

namespace common\widgets\yamap;

use yii\widgets\InputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use Yii;

/**
 * Class YaMapInput
 * Виджет выбора координат с помощью яндекс карты
 * @package common\widgets\yamap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapInput extends InputWidget
{

	public $assetBundle = "\\common\\widgets\\yamap\\YaMapInputAsset";

	/**
	 * @var array настройки карты по умолчанию
	 */
	public $defaultMapOptions = [
		'width' => 620,
		'height' => 430,
		'zoom' => '15',
		'center' => [54.629148, 39.735243],
	];

	/**
	 * @var array опции диалогового окна
	 */

	protected $_dialogOptions = [];

	/**
	 * @var array опции карты
	 */

	protected $_mapOptions = [];

	/**
	 * @var array опции диалогового окна по умолчанию
	 */
	protected $_defaultDialogOptions;

	/**
	 * @var string id обертки виджета
	 */

	protected $containerId;

	/**
	 * @var string id контейнера карты
	 */

	protected $mapId;

	/**
	 * Возвращает настройки диалогового окна по умолчанию
	 * @return array
	 */
	public function getDefaultDialogOptions()
	{

		if($this->_defaultDialogOptions === null) {

			$this->_defaultDialogOptions = [
				'title' => Yii::t('core', 'Coordinates select'),
				'autoOpen' => false,
				'width' => 650,
				'height' => 550,
			];

		}

		return $this->_defaultDialogOptions;

	}

	/**
	 * Устанавливает настройки диалогового окна по умолчанию
	 * @param array $defaultDialogOptions
	 */
	public function setDefaultDialogOptions($defaultDialogOptions)
	{
		$this->_defaultDialogOptions = $defaultDialogOptions;
	}


	/**
	 * Возвращает опции для диалогового окна
	 * @return array|mixed
	 */
	public function getDialogOptions()
	{

		return ArrayHelper::merge($this->defaultDialogOptions, $this->_dialogOptions);

	}

	/**
	 * Устанавливает настройки диалогового окна
	 * @param array $val настройки
	 */
	public function setDialogOptions(Array $val)
	{
		$this->_dialogOptions = $val;
	}

	/**
	 * Возвращает опции для карты
	 * @return array|mixed
	 */
	public function getMapOptions()
	{

		return ArrayHelper::merge($this->defaultMapOptions, $this->_mapOptions);

	}

	/**
	 * Устанавливает настройки карты
	 * @param array $val настройки карты
	 */
	public function setMapOptions(Array $val)
	{
		$this->_mapOptions = $val;
	}

	/**
	 * @inheritdoc
	 */
	public function init()
	{

		parent::init();

		$assetBundle = $this->assetBundle;

		$assetBundle::register($this->view);

		$id = $this->options["id"];

		$this->containerId = $id . "-wrapper";

		$this->mapId = $id . "-map";

		$options = array(

			"mapId" => $this->mapId,

			"dialog" => $this->getDialogOptions(),

			"map" => $this->getMapOptions(),

		);

		Yii::$app->view->registerJs("
			$('#{$this->containerId}').yamapInput(" . Json::encode($options) . ")
		");

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		$map = $this->getMapOptions();

		$html = Html::beginTag('div', ["id" => $this->containerId]);

		if ($this->hasModel())
			$html .= Html::activeTextInput($this->model, $this->attribute, $this->options);
		else
			$html .= Html::textInput($this->name, $this->value, $this->options);

		$html .= Html::tag('div',

			Html::textInput('yamap-search', '', ['placeholder'=>Yii::t('core', 'Input address and press Enter'), 'class' => 'yamap-search form-control', 'style' => 'width: 50%; margin-bottom: 5px']) .

			Html::tag('div', '', ["class" => "yamap-area", "style" => "width: {$map["width"]}px; height: {$map["height"]}px", "id" => $this->mapId])

			, ["class" => "yamap-dialog"]
		);

		$html .= Html::endTag('div');

		return $html;

	}


}
