<?php
namespace app\modules\shop\components;

use \app\modules\shop\models\Order;
use \app\modules\shop\models\Delivery;

/**
 * Interface IDeliveryConstraint
 * Интерфес ограничения на способы доставки
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com
 */
interface IDeliveryConstraint
{

    /**
     * Доступен ди в заказе способ доставки
     * @param Order $order заказ
     * @param Delivery $delivery способ доставки
     * @return bool
     */
    public function isEnabled(Order $order, Delivery $delivery);

}