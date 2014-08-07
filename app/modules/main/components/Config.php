<?php

namespace app\modules\main\components;

use yii\base\Object;
use yii\helpers\ArrayHelper;
use app\modules\main\models\Config AS Model;

/**
 * Class Config
 * Компонент доступа к настройкам хранящимся в БД
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Config extends Object
{

	/**
	 * @var array массив с конфигурацией
	 */
	protected $_config;

	/**
	 * Возвращает массив с конфигурацией
	 * @return array
	 */
	protected function getConfig()
	{

		if($this->_config === null) {

			$models = Model::find()->published()->all();

			$this->_config = ArrayHelper::map($models, "key", "value");
		}

		return $this->_config;
	}

	/**
	 * Возвращает значение по ключу
	 * @param string $key ключ
	 * @return string|null
	 */
	public function get($key)
	{
		$config = $this->getConfig();

		return isset($config[$key])?$config[$key]:null;
	}

}