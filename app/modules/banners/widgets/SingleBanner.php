<?php
namespace app\modules\banners\widgets;

use common\widgets\App;
use \app\modules\banners\models\Place;

/**
 * Class SingleBanner
 * Виджет отображения одного баннера по коду баннерного места.
 * Баннеры с одинаковым кодом ротируются в случайном порядке.
 * @package app\modules\banners\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SingleBanner extends App
{

	/**
	 * @var string символьный код баннерного места.
	 */
	public $code;

	/**
	 * @var \app\modules\banners\models\Banner модель баннера
	 */
	protected $model;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if(!$this->isShow())
			return false;

		$place = Place::find()->published()->andWhere(["code"=>$this->code])->one();

		if($place) {

			$models = $place->getBanners()->published()->all();

			$i  = rand(0, count($models)-1);

			$this->model = $models[$i];

		}

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		if(!$this->isShow() OR !$this->model)
			return false;

		$renderer = \app\modules\banners\components\AbstractRenderer::getRenderer($this->model);

		if($renderer)
			return $renderer->render();

	}


}