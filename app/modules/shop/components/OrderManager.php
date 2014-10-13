<?php
namespace app\modules\shop\components;

use yii\base\Component;
use app\modules\shop\models\Order;
use Yii;
/**
 * Class OrderManager
 * Компонент получения текущего заказа
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class OrderManager extends Component
{

	/**
	 * @var string ключ сесси для хранения заказа
	 */
	public $sessionKey = "RZ_ORDER";

	/**
	 * @var Order заказ
	 */
	protected $_order;


	/**
	 * Получает объект заказа из сессии
	 * @param bool $refresh получить заново
	 * @return Order
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getOrder($refresh = false)
	{

		if($this->_order === null OR $refresh) {

			$this->_order = Yii::$app->session->get($this->sessionKey);

			if(!$this->_order) {

				$this->_order = Yii::createObject(Order::className());

			}

		}

        $this->_order->clearErrors();

		return $this->_order;

	}

	/**
	 * Сохраняет объект заказа в сессию
	 * @param Order $order объект заказа
	 */

	public function saveOrder(Order $order) {

		Yii::$app->session->set($this->sessionKey, $order);

	}

	/**
	 * Удаляем объект заказа из сессии
	 */
	public function removeOrder() {

		Yii::$app->session->remove($this->sessionKey);

	}


}