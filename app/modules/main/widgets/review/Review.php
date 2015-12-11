<?php

namespace app\modules\main\widgets\review;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use app\modules\main\models\Review as Model;

/**
 * Class Review
 * Виджет создания отзыва
 * @property-read Model $model объект модели отзыва
 * @package app\modules\main\widgets\review
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class Review extends Widget
{

	/**
	 * @var string класс модели, для которой создается отзыв
	 */
	public $modelClass;

	/**
	 * @var integer идентификатор модели, для которой создается отзыв
	 */
	public $itemId;

	/**
	 * @var string класс модели, на основе которой создается отзыв
	 */
	public $sourceModelClass;

	/**
	 * @var integer идентификатор модели, на основе которой создается отзыв
	 */
	public $sourceItemId;

	/**
	 * @var array параметры формы
	 */
	public $formOptions = [];

	/**
	 * @var string маршрут добавления комментария
	 */
	public $actionRoute = '/main/service/review';

	/**
	 * @var string шаблон
	 */
	public $tpl = 'create';

	/**
	 * @var Review экземпляр модели отзыва
	 */
	protected $_model;

	public function init()
	{

		ReviewAsset::register($this->view);

		$this->view->registerJs("$('#$this->id').reviewWidget()");

	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$formOptions = ArrayHelper::merge([
			'id' => "$this->id-form",
			'action' => Yii::$app->urlManager->createUrl($this->actionRoute),
			"enableClientValidation" => true,
			"enableAjaxValidation" => false,
			"validateOnSubmit" => true,
		], $this->formOptions);

		return $this->render($this->tpl, [
			'id' => $this->id,
			'model' => $this->model,
			'formOptions' => $formOptions,
		]);
	}

	/**
	 * Возвращает объект модели отзыва
	 * @return Model
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getModel()
	{

		if (is_null($this->_model)) {
			$this->_model = Yii::createObject([
				'class' => Model::className(),
				'scenario' => Model::SCENARIO_INSERT,
				'model' => $this->modelClass,
				'item_id' => $this->itemId,
				'source_model' => is_null($this->sourceModelClass) ? $this->modelClass : $this->sourceModelClass,
				'source_item_id' => is_null($this->sourceItemId) ? $this->itemId : $this->sourceItemId,
			]);
		}

		return $this->_model;
	}
}