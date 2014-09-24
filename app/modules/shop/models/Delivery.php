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

}