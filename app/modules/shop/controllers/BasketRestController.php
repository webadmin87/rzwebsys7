<?php
namespace app\modules\shop\controllers;

use yii\rest\Controller;
use Yii;

/**
 * Class BasketRestController
 * Контроллер обрабатывающий запросы к корзине
 * @package app\modules\shop\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BasketRestController extends Controller
{

	/**
	 * @var \app\modules\shop\components\Basket
	 */
	protected $basket;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		$this->basket = $this->module->basket;

		parent::init();

	}


	/**
	 * Добавление товара в корзину
	 * @throws \yii\base\ErrorException
	 */
	public function actionAdd()
	{

		$r = Yii::$app->request;

		$this->basket->add($r->post("id"), $r->post("class"), $r->post("qty", 1));

		Yii::$app->response->statusCode = 201;

		return $this->basket->getStat();
	}

	/**
	 * Изменение количества товара в корзине
	 * @param int $id идентификатор элемента
	 * @param string $class класс элемента каталога
	 * @return \app\modules\shop\models\Order
	 */
	public function actionUpdate($id, $class)
	{

		$r = Yii::$app->request;

		$this->basket->updateNewQty($id, $class, $r->post("qty"));

		return $this->basket->getOrder();

	}


	/**
	 * Удаление товара из корзины
	 * @param int $id идентификатор элемента добавляемого в корзину
	 * @param string $class класс элемента каталога
	 * @return \app\modules\shop\models\Order
	 */
	public function actionDelete($id, $class)
	{
		$res = $this->basket->removeNew($id, $class);

		return $this->basket->getOrder();

	}


	/**
	 * Заказ
	 * @return \app\modules\shop\models\Order
	 */
	public function actionOrder()
	{

		return $this->basket->getOrder();

	}

	/**
	 * Возвращает статистику по заказу.
	 * @return array
	 */
	public function actionStat()
	{
		return $this->basket->getStat();
	}

	/**
	 * @inheritdoc
	 */
	public function verbs() {

		return [

			'add'=>['post'],
			'delete'=>['delete'],
			'update'=>['put'],

		];

	}


}