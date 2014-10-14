<?php
/**
 * @var \app\modules\shop\models\Order $order модель заказа
 * @var array $deliveries массив способов доставки id=>title
 * @var array $payments массив способов оплаты id=>title
 */
?>

<h1><?=Yii::t('shop/app', 'Process order')?></h1>

<div ng-controller="ProcessOrderCtrl as ctrl" ng-cloak>

    <?=$this->render('_order')?>

    <div class="alert alert-success" ng-show="success == true"><?=Yii::t('shop/app', 'Order success')?></div>

    <div class="alert alert-danger" ng-show="success == false"><?=Yii::t('shop/app', 'Order error')?></div>

    <div ng-hide="success">

        <h2><?=Yii::t('shop/app', 'Client info')?></h2>


        <?=$this->render('_form', ["order"=>$order, "deliveries"=>$deliveries, "payments"=>$payments])?>

    </div>

</div>