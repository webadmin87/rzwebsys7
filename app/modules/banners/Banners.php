<?php
namespace app\modules\banners;

/**
 * Class Banners
 * Баннерный модуль
 * @package app\modules\banners
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Banners extends \yii\base\Module
{
	/**
	 * @var string пространство имен контроллеров
	 */
	public $controllerNamespace = 'app\modules\banners\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
