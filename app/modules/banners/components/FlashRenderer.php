<?php
namespace app\modules\banners\components;

use Yii;
use yii\helpers\Html;

/**
 * Class ImageRenderer
 * Класс для рендеринга флеш - баннеров
 * @package app\modules\banners\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class FlashRenderer extends AbstractRenderer
{

	/**
	 * @var string ассет библиотеки swfobject
	 */
	public $swfAssetClass = "\\app\\assets\\SwfObjectAsset";

	/**
	 * @var string версия плеера
	 */
	public $version = '9.0.0';

	/**
	 * Рендер баннера
	 * @return string
	 */
	public function render()
	{

		$file = $this->model->getFirstFile('image');

		if(!$file)
			return null;

		$asset = $this->swfAssetClass;

		$asset::register(Yii::$app->view);

		$id = uniqid(rand());

		Yii::$app->view->registerJs("

			swfobject.embedSWF(
				'{$file->getRelPath()}', '$id', '{$this->model->width}', '{$this->model->height}', '{$this->version}',
				'expressInstall.swf', {}, {wmode: 'opaque'}
			);

		");


		$bl = Html::tag('div', '', ["id"=>$id]);

		if(!$this->model->link)
			return $bl;
		else {

			$a = Html::a('', $this->model->link, ["target"=>$this->model->target, "style"=>"position:absolute; display: block; width:{$this->model->width}px; height: {$this->model->height}px;"]);

			$wrap = Html::tag('div', $a.$bl, ['style'=>'position:relative; display: inline-block;']);

			return $wrap;

		}
	}


}