<?php
namespace app\modules\banners\components;

use yii\helpers\Html;

/**
 * Class ImageRenderer
 * Класс для рендеринга баннеров - изображений
 * @package app\modules\banners\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ImageRenderer extends AbstractRenderer
{
	/**
	 * Рендер баннера
	 * @return string|null
	 */
	public function render()
	{

		$file = $this->model->getFirstFile('image');

		if(!$file)
			return null;

		$img = Html::img($file->getRelPath(), ["width"=>$this->model->width, "height"=>$this->model->height]);

		if($this->model->link)
			return Html::a($img, $this->model->link, ["target"=>$this->model->target]);
		else
			return $img;
	}


}