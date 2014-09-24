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


}