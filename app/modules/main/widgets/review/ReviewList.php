<?php

namespace app\modules\main\widgets\review;

use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use app\modules\main\models\Review;
use yii\helpers\ArrayHelper;

/**
 * Class ReviewList
 * Виджет списка отзывов
 * @property-read ActiveDataProvider $dataProvider провайдер данных
 * @property \yii\web\AssetBundle $skinAsset
 * @package app\modules\main\widgets\review
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ReviewList extends Widget
{

	/**
	 * @var string класс модели
	 */
	public $modelClass;

	/**
	 * @var int идентификатор элемента
	 */
	public $itemId;

	/**
	 * @var int количество отзывов на одной странице. 0 - нет пагинации
	 */
	public $pageSize = 0;

	/**
	 * @var array сортировка
	 */
	public $orderBy = ['created_at' => SORT_DESC];

	/**
	 * @var callable функция для преобразования запроса. Принимает аргумент \common\db\ActiveQuery
	 */
	public $queryModifier;

	/**
	 * @var array дополнительная конфигурация провайдера данных
	 */
	public $dataProviderConfig = [];

	/**
	 * @var string шаблон
	 */
	public $tpl = "index";

	/**
	 * @var \yii\web\AssetBundle ассет скина
	 */
	protected $_skinAsset;

	/**
	 * @var ActiveDataProvider
	 */
	protected $_dataProvider;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$skin = $this->skinAsset;

		if ($skin) {
			$skin::register($this->view);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{

		return $this->render($this->tpl, [
			'id' => $this->id,
			'dataProvider' => $this->dataProvider,
		]);
	}

	/**
	 * Возвращает объект провайдера данных
	 * @return object|ActiveDataProvider
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getDataProvider()
	{
		if ( is_null($this->_dataProvider) ) {

			$query = Review::find()->published()->byItem($this->itemId, $this->modelClass);

			if (is_callable($this->queryModifier)) {
				$func = $this->queryModifier;
				$func($query);
			}

			$config = ArrayHelper::merge($this->dataProviderConfig, [
				'class' => ActiveDataProvider::className(),
				'query' => $query,
			]);

			$this->_dataProvider = Yii::createObject($config);
			$this->_dataProvider->pagination->pageSize = $this->pageSize;
			$this->_dataProvider->sort->defaultOrder = $this->orderBy;

		}

		return $this->_dataProvider;
	}

	/**
	 * Возвращает ассет скина
	 * @return \yii\web\AssetBundle
	 */

	public function getSkinAsset()
	{
		if ($this->_skinAsset === null) {
			$this->_skinAsset = SkinAsset::className();
		}

		return $this->_skinAsset;
	}

	/**
	 * Установка ассета скина
	 * @param \yii\web\AssetBundle $val
	 */

	public function setSkinAsset($val)
	{
		$this->_skinAsset = $val;
	}

}