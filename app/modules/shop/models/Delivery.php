<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;

/**
 * Class Delivery
 * Модель способов доставки
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Delivery extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @var float расчитанная стоимость доставки
     */
    protected $_deliveryPrice;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_delivery";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\DeliveryMeta::className();
    }

	/**
	 * Связь со способами доставки
	 * @return \yii\db\ActiveQuery
	 */
	public function getDelivery()
	{
		return $this->hasOne(Delivery::className(), ["id"=>"delivery_id"]);
	}

	/**
	 * Связь со способами оплаты
	 * @return \yii\db\ActiveQuery
	 */
	public function getPayment()
	{
		return $this->hasOne(Payment::className(), ["id"=>"payment_id"]);
	}

	/**
	 * Связь с заказаннами товарами
	 * @return mixed
	 */
	public function getGoods()
	{

		return $this->hasMany(Good::className(), ["order_id"=>"id"])->published();

	}

    /**
     * Расчет стоимости доставки
     * @param Order $order заказа
     * @param bool $refresh перерасчитать, если уже расчитано
     * @return float
     */
    public function getDeliveryPrice($order, $refresh=false)
    {

        if($this->_deliveryPrice === null OR $refresh) {

            if(!empty($this->class)) {

                $calc = Yii::createObject($this->class);

                $this->_deliveryPrice = $calc->calc($order, $this);

            } elseif(!empty($this->free_limit) AND $order->getGoodsPrice()>=$this->free_limit) {

                $this->_deliveryPrice = 0;

            } else {

                $this->_deliveryPrice = $this->price;

            }

        }

        return $this->_deliveryPrice;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parent = parent::rules();

        $parent[] = ['sort', 'default', 'value'=>500];

        return $parent;
    }

}