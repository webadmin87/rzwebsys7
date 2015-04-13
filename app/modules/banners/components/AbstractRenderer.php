<?php
namespace app\modules\banners\components;

use Yii;
use yii\base\Object;

/**
 * Class AbstractRenderer
 * Абстрактный класс компонента рендеринга баннеров
 * @package app\modules\banners\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
abstract class AbstractRenderer extends Object
{

	/**
	 * @var \app\modules\banners\models\Banner модель баннера
	 */
	protected $model;

	/**
	 * Конструктор
	 * @param \app\modules\banners\models\Banner $model модель баннера
	 * @param array $config параметры объекта
	 */
	public function __construct(\app\modules\banners\models\Banner $model, $config=[])
	{
		$this->model = $model;
		parent::__construct($config);
	}

	/**
	 * Возвращает объект для рендера баннера
	 * @param \app\modules\banners\models\Banner $model модель баннера
	 * @return null|AbstractRenderer
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function getRenderer(\app\modules\banners\models\Banner $model) {

		return Yii::$app->getModule('banners')->rendererFactory->createRenderer($model);
	}

	/**
	 * Рендер баннера
     * @param bool $renderLink рендерить ли ссылку
	 * @return string
	 */
	public abstract function render($renderLink=true);

}