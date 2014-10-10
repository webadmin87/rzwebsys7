<?php
namespace app\modules\shop\components;

use \app\modules\shop\models\Order;
use \app\modules\shop\models\Payment;

/**
 * Interface IPaymentConstraint
 * Интерфес ограничения на способы оплаты
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com
 */
interface IPaymentConstraint
{

    /**
     * Доступен ди в заказе способ оплаты
     * @param Order $order заказ
     * @param Payment $payment способ оплаты
     * @return bool
     */
    public function isEnabled(Order $order, Payment $payment);

}