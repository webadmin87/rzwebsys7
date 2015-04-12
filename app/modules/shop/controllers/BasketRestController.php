<?php
namespace app\modules\shop\controllers;

use app\modules\shop\models\Order;
use yii\rest\Controller;
use Yii;
use yii\helpers\ArrayHelper;

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

		$this->basket->add($r->post("id"), $r->post("class"), $r->post("qty", 1), $r->post('attrs', []));

		Yii::$app->response->statusCode = 201;

		return $this->basket->getStat();
	}

	/**
	 * Изменение количества товара в корзине
	 * @param int $key ключ (идентификатор) элемента в корзине
	 * @return \app\modules\shop\models\Order
	 */
	public function actionUpdate($key)
	{

		$r = Yii::$app->request;

		$this->basket->updateNewQty($key, $r->post("qty"));

		return $this->basket->getOrder();

	}


	/**
	 * Удаление товара из корзины
	 * @param int $key ключ (идентификатор) элемента в корзине
	 * @return \app\modules\shop\models\Order
	 */
	public function actionDelete($key)
	{
		$res = $this->basket->removeNew($key);

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
     * Установка значений свойств заказа
     * @return \app\modules\shop\models\Order
     */
    public function actionSetOrder()
    {

        return $this->basket->setOrder(Yii::$app->request->post());

    }

    /**
     * Способы доставки
     * @return array
     */
    public function actionDeliveries()
    {

        return $this->basket->getOrder()->getDeliveries();

    }

    /**
     * Способы оплаты
     * @return array
     */
    public function actionPayments()
    {

        return $this->basket->getOrder()->getPayments();

    }

	/**
	 * Подтверждение заказа. Заказ сохраняется в БД
	 * @return \app\modules\shop\models\Order
	 */
	public function actionConfirm()
	{

		$this->basket->setOrder(Yii::$app->request->post());

		$order = $this->basket->getOrder();

		$order->setScenario(Order::SCENARIO_CONFIRM);

		$res = $order->save();

		if($res) {
			Yii::$app->getModule('shop')->adminNotifier->notify($order);
			$this->basket->orderManager->removeOrder();
			Yii::$app->response->statusCode = 201;
		}

		return $order;

	}

	/**
	 * @inheritdoc
	 */
	public function verbs() {

		return [
			'confirm'=>['post'],
			'add'=>['post'],
            'set-order'=>['put'],
			'delete'=>['delete'],
			'update'=>['put'],

		];

	}


}