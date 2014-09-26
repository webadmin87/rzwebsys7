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

	public function init()
	{
		$this->basket = $this->module->basket;

		parent::init();

	}


	/**
	 * Добавление товара в корзину
	 * @param int $id идентификатор элемента добавляемого в корзину
	 * @param string $class класс элемента каталога
	 * @param int $qty количество
	 * @throws \yii\base\ErrorException
	 */
	public function actionAdd($id, $class, $qty = 1)
	{

		$this->basket->add($id, $class, $qty);

		Yii::$app->response->statusCode = 201;

	}

	/**
	 * Удаление товара из корзины
	 * @param int $id идентификатор элемента добавляемого в корзину
	 * @param string $class класс элемента каталога
	 */
	public function actionDelete($id, $class)
	{
		$res = $this->basket->removeNew($id, $class);

		if($res)
			Yii::$app->response->statusCode = 204;

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
			'delete'=>['delete']

		];

	}


}