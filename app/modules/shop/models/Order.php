<?php
namespace app\modules\shop\models;

use Yii;
use common\db\ActiveRecord;

/**
 * Class Order
 * Модель заказа
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Order extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	const SCENARIO_CONFIRM = "confirm";

	/**
	 * @var Good[] массив новых товаров добавленных к заказу
	 */
	protected $_goods = [];

	/**
	 * @inheritdoc
	 */
	public function init() {

		parent::init();

		if($this->scenario == self::SCENARIO_CONFIRM) {

			$this->active = true;

		}

	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		$arr = parent::rules();

		$arr[] = ['allGoods', 'required', 'on'=>[self::SCENARIO_CONFIRM]];

		return $arr;
	}


	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_orders";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\OrderMeta::className();
    }

	/**
	 * Связь с заказанными товарами
	 * @return \yii\db\ActiveQuery
	 */
	public function getGoods()
	{
		return $this->hasMany(Good::className(), ["order_id"=>"id"]);
	}

    /**
     * Связь со способом доставки
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::className(), ["id"=>"delivery_id"]);
    }

    /**
     * Связь со способом оплаты
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ["id"=>"payment_id"]);
    }

	/**
	 * Связь со статусами
	 * @return \yii\db\ActiveQuery
	 */
	public function getStatus()
	{
		return $this->hasOne(Status::className(), ["id"=>"status_id"]);
	}

    /**
     * Расчет стоимости доставки
     * @return float
     */
    public function calcDeliveryPrice()
    {

        if($this->delivery) {

            $this->delivery_price = $this->delivery->getDeliveryPrice($this);

        }

        return $this->delivery_price;

    }

	/**
	 * Возвращает все товары, уже сохраненные и новые
	 * @return array
	 */
	public function getAllGoods()
	{
		return array_merge($this->goods, $this->_goods);
	}

	/**
	 * Возвращает количество заказанных товаров
	 * @return int
	 */
	public function countAllGoods()
	{
		$i = 0;

		foreach ($this->getAllGoods() as $good) {
			$i += $good->qty;
		}

		return $i;
	}

	/**
	 * Возвращает общую стоимость заказанных товаров
	 * @return float
	 */
	public function getGoodsPrice()
	{

		$price = 0;

		foreach ($this->getAllGoods() as $good) {

			$price += $good->getFinalPrice()*$good->qty;

		}

		return $price;

	}

	/**
	 * Возвращает общую стоимость заказа
	 * @return float
	 */
	public function getTotalPrice()
	{

		return $this->getGoodsPrice() + (double) $this->delivery_price;

	}

	/**
	 * Возвращает новые товары добавленные к заказу
	 * @return Goods[]
	 */
	public function getNewGoods()
	{
		return $this->_goods;
	}

	/**
	 * Добавляет новый товар к заказу
	 * @param Good $good
	 */
	public function addNewGood(Good $good)
	{

		$model = $this->hasGood($good);

		if(!$model)
			$this->_goods[] = $good;
		else {
			$model->qty += $good->qty;
		}


	}

	/**
	 * Содержит ли заказ данный товар
	 * @param Good $good модель товара
	 * @return Good|bool
	 */
	public function hasGood(Good $good)
	{

		foreach($this->getNewGoods() AS $model) {

			if($model->item_key == $good->item_key)
				return $model;

		}

		return false;

	}

	/**
	 * Изменяет количество нового товара в заказе
	 * @param string $itemKey ключ (идентификатор) элемента каталога
	 * @param $qty количество заказываемого товара
	 * @return bool
	 */
	public function updateNewGood($itemKey, $qty)
	{

		foreach($this->_goods AS $k => $good) {

			if($good->item_key == $itemKey) {

				$this->_goods[$k]->qty = $qty;

				return true;

			}

		}

		return false;

	}

	/**
	 * Удаляет новый товар из заказа
	 * @param string $itemKey ключ (идентификатор) элемента каталога
	 * @return bool
	 */
	public function removeNewGood($itemKey)
	{

		foreach($this->_goods AS $k => $good) {

			if($good->item_key == $itemKey) {

				unset($this->_goods[$k]);

				return true;

			}

		}

		return false;

	}

	/**
	 * Удаляет товар из заказа
	 * @param Good $good
	 * @throws \yii\base\InvalidCallException
	 */
	public function removeGood(Good $good)
	{

		$this->unlink("goods", $good, true);

	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {

			$this->calcDeliveryPrice();

			return true;

		}

		return false;

	}


	/**
	 * @inheritdoc
	 * Сохраняет добавленные к заказу товары. Отправляет уведомление пользователю, если статус заказа изменился.
	 */
	public function afterSave($insert, $changedAttributes)
	{

		foreach($this->_goods AS $k => $good) {

			$this->link("goods", $good);

		}

		$this->_goods = [];

		// Отправляем уведомление клиенту при изменении статуса заказа

		if(in_array("status_id", array_keys($changedAttributes)) AND $changedAttributes["status_id"] != $this->status_id) {

			Yii::$app->getModule('shop')->clientNotifier->notify($this);

		}

		return parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		$arr = parent::fields();

		$arr = array_merge($arr, ["allGoods", "totalPrice", "payments", "deliveries"]);

		return $arr;

	}

    /**
     * Массив способов доставки
     * @return Delivery[]
     */
    public function getDeliveries()
    {

        return Delivery::find()->published()->orderBy(['sort'=>SORT_ASC])->all();

    }

    /**
     * Массив способов оплаты
     * @return Payment[]
     */
    public function getPayments()
    {

        return Payment::find()->published()->orderBy(['sort'=>SORT_ASC])->all();

    }

	/**
	 * Получение заново связанных объектов
	 */
	public function reloadRelated()
	{

		$this->populateRelation('delivery',  $this->getDelivery()->one());

		$this->populateRelation('payment',  $this->getPayment()->one());

	}

	/**
	 * @inheritdoc
	 */
	public function  scenarios()
	{
		$parent = parent::scenarios();

		$arr = array_diff($parent[self::SCENARIO_CONFIRM], ["allGoods"]);

		$parent[self::SCENARIO_CONFIRM] = array_merge($arr, ["!allGoods"]);

		return $parent;

	}


}