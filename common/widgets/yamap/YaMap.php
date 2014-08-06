<?php

namespace common\widgets\yamap;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class YaMap
 * Виджет отображения Яндекс карты
 * @package common\widgets\yamap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMap extends Widget
{

	/**
	 * @var array параметры карты
	 */
	public $mapOptions = [
		"zoom" => 15,
	];

	/**
	 * @var array html атрибуты контейнера карты
	 */
	public $containerOptions = [
		"style" => "width: 500px; height: 500px",
	];

	/**
	 * @var array массив точек
	 * Каждая точка массив параметров конструктора Placemark
	 * @link http://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Placemark.xml
	 */
	public $coordinates = [];

	/**
	 * @inheritdoc
	 */
	public function init()
	{

		$id = $this->getId();

		YaMapApiAsset::register($this->view);

		$mapOptions = $this->mapOptions;

		if (empty($mapOptions["center"]) AND !empty($this->coordinates[0][0]))
			$mapOptions["center"] = $this->coordinates[0][0];

		$this->view->registerJs("
			ymaps.ready(function () {
				var construct = function(constructor, args) {
					function F() {
						return constructor.apply(this, args);
					}
					F.prototype = constructor.prototype;
					return new F();
				}
				var map = new ymaps.Map($id, " . Json::encode($mapOptions) . ");
				var collection =  new ymaps.GeoObjectCollection();
				var conf = " . Json::encode($this->coordinates) . ";
				for(var k in conf) {
					var placemark =  construct(ymaps.Placemark, conf[k]);
					collection.add(placemark);
				}
				map.geoObjects.add(collection);
			});");

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		$options = $this->containerOptions;

		$options["id"] = $this->getId();

		return Html::tag('div', '', $options);

	}

}