<?php
namespace app\modules\shop\components;

use \app\modules\shop\models\Delivery;
use \app\modules\shop\models\Order;

/**
 * Interface IDeliveryCalc
 * Интерфейс рачета стоимости доставки
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
interface IDeliveryCalc
{

    /**
     * Расчет стоимости доставки
     * @param Order $order заказ
     * @param Delivery $delivery модель доставки
     * @return float
     */
    public function calc(Order $order, Delivery $delivery);

}