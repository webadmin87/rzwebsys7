<?php
namespace app\modules\banners\widgets;

use common\widgets\App;
use \app\modules\banners\models\Place;

/**
 * Class ListBanners
 * Отображает все баннеры по коду баннерного места
 * Баннеры с одинаковым кодом ротируются в случайном порядке.
 * @package app\modules\banners\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListBanners extends App
{

	/**
	 * @var string символьный код баннерного места.
	 */
	public $code;

	/**
	 * @var array параметры тега контейнера
	 */
	public $containerOptions = [];

	/**
	 * @inheritdoc
	 */
	public $tpl = "list";

	/**
	 * @var \app\modules\banners\models\Banner[] модели баннеров
	 */
	protected $models;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if(!$this->isShow())
			return false;

		$place = Place::find()->published()->andWhere(["code"=>$this->code])->one();

		if($place) {

			$this->models = $place->getBanners()->published()->orderBy(["sort"=>SORT_ASC])->all();

            foreach($this->models AS $k => $banner) {

                if(!$banner->isSuitable()) {
                    unset($this->models[$k]);
                }

            }

		}

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		if(!$this->isShow() OR !$this->models)
			return false;

		return $this->render($this->tpl, ["models"=>$this->models, "containerOptions"=>$this->containerOptions]);

	}


}