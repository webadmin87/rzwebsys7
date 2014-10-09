<?php
/**
 * @var string|array $url url кнопки в корзину
 */

use yii\helpers\Html;
?>
<div ng-controller="BasketInfoCtrl">
    <span class="basket-count">Товаров в корзине: <span>{{stat.count}}</span></span><br />
    <span class="basket-summ">На сумму: <span>{{stat.summ | currency}}</span></span><br />
    <?=Html::a(Yii::t('shop/app', 'Basket'), $url, ['class'=>"btn btn-default"])?>
</div>