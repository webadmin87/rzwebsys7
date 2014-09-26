<?php
namespace app\modules\shop\models;

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

		$this->_goods[] = $good;

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
	public function afterSave($insert)
	{

		$this->owner->setIsNewRecord(false);

		foreach($this->_goods AS $k => $good) {

			$this->link("goods", $good);

		}

		$this->_goods = [];

		return parent::afterSave($insert);
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		$arr = parent::fields();

		$arr = array_merge($arr, ["allGoods"]);

		return $arr;

	}


}