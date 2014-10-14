<?php
/**
 * @var \app\modules\shop\models\Order $order заказ
 */

use yii\helpers\Url;

$f = Yii::$app->formatter;
?>

<table class="table table-striped">
    <tr><th><?=Yii::t('shop/app', 'Title')?></th><th><?=Yii::t('shop/app', 'Qty')?></th><th><?=Yii::t('shop/app', 'Price')?></th><th><?=Yii::t('shop/app', 'Total price')?></th></tr>

    <?foreach($order->getAllGoods() as $good):?>
        <tr>
            <td><a href="<?=Url::toRoute(['/shop/admin/good/view', 'id'=>$good->id])?>"><?=$good->title?></a></td>
            <td><?=$good->qty?></td>
            <td><?=$f->asCurrency($good->getFinalPrice())?></td>
            <td><?=$f->asCurrency($good->getFinalPrice()*$good->qty)?></td>
        </tr>
    <?endforeach;?>
    <tr><td colspan="4"><strong><?=Yii::t('shop/app', 'Delivery price')?></strong>: <?=$f->asCurrency($order->delivery_price)?></td></tr>
    <tr><td colspan="4"><strong><?=Yii::t('shop/app', 'Total price')?></strong>: <?=$f->asCurrency($order->getTotalPrice())?></td></tr>
</table>
