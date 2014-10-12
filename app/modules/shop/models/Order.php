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

	/**
	 * @var Goods[] массив новых товаров добавленных к заказу
	 */
	protected $_goods = [];

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
     * Расчет стоимости доставки
     * @return float
     */
    public function calcDeliveryPrice()
    {

        $delivery = $this->getDelivery()->one();

        if($delivery) {

            $this->delivery_price = $delivery->getDeliveryPrice($this);

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
			$model->qty = $good->qty;
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

			if($model->item_id == $good->id AND $model->item_class == $good->item_class)
				return $model;

		}

		return false;

	}

	/**
	 * Удаляет новый товар из заказа
	 * @param int $itemId идентификатор элемента каталога
	 * @param string $itemClass класс элемента каталога
	 * @return bool
	 */
	public function removeNewGood($itemId, $itemClass)
	{

		foreach($this->_goods AS $k => $good) {

			if($good->item_id == $itemId AND $good->item_class == $itemClass) {

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
	 * Сохраняет добавленные к заказу товары
	 */
	public function afterSave($insert, $changedAttributes)
	{

		$this->owner->setIsNewRecord(false);

		foreach($this->_goods AS $k => $good) {

			$this->link("goods", $good);

		}

		$this->_goods = [];

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

}