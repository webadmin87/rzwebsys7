<?php
/**
 * @var \app\modules\shop\models\Order $order модель заказа
 * @var array $deliveries массив способов доставки id=>title
 * @var array $payments массив способов оплаты id=>title
 */
?>

<h1><?=Yii::t('shop/app', 'Process order')?></h1>

<div ng-controller="ProcessOrderCtrl as ctrl">

    <?=$this->render('_order')?>

    <h2><?=Yii::t('shop/app', 'Client info')?></h2>

    <?=$this->render('_form', ["order"=>$order, "deliveries"=>$deliveries, "payments"=>$payments])?>

</div>