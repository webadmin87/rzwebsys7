<?php
/**
 * @var string|array $url url кнопки в корзину
 */

use yii\helpers\Html;
?>
<div ng-controller="BasketInfoCtrl">
    <p class="basket-count">Товаров в корзине: <span>{{stat.count}}</span></p>
    <p class="basket-summ">На сумму: <span>{{stat.summ | currency}}</span></p>
    <?=Html::a(Yii::t('shop/app', 'Basket'), $url, ['class'=>"btn btn-default"])?>
</div>