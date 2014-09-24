<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;

/**
 * Class Good
 * Модель заказанного товара
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Good extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_goods";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\GoodMeta::className();
    }

	/**
	 * Связь с заказом
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrder()
	{
		return $this->hasOne(Order::className(), ["id"=>"order_id"]);
	}

}