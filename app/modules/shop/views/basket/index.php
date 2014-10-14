<?php
use yii\helpers\Html;
?>

<h1><?=Yii::t('shop/app', 'Basket')?></h1>

<div ng-controller="OrderListCtrl as ctrl" ng-cloak>

    <?=$this->render('_order')?>

    <?=Html::a(Yii::t('shop/app', 'Process order'), '/shop/basket/process', ['class'=>'btn btn-primary', 'ng-show'=>'order.allGoods.length>0'])?>

</div>