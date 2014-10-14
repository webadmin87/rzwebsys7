<?php
/**
 * @var \app\modules\shop\models\Order $order заказ
 */
$f = Yii::$app->formatter;
?>

<table border="1">
    <tr><th><?=Yii::t('shop/app', 'Title')?></th><th><?=Yii::t('shop/app', 'Qty')?></th><th><?=Yii::t('shop/app', 'Price')?></th><th><?=Yii::t('shop/app', 'Total price')?></th><th></th></tr>

    <?foreach($order->getAllGoods() as $good):?>
        <tr>
            <td><a href="<?=$good->link?>"><?=$good->title?></a></td>
            <td><?=$good->qty?></td>
            <td><?=$f->asCurrency($good->price)?></td>
            <td><?=$f->asCurrency($good->price*$good->qty)?></td>
        </tr>
    <?endforeach;?>
    <tr><td colspan="5"><?=Yii::t('shop/app', 'Delivery price')?>: <?=$f->asCurrency($order->delivery_price)?></td></tr>
    <tr><td colspan="5"><?=Yii::t('shop/app', 'Total price')?>: <?=$f->asCurrency($order->getTotalPrice())?></td></tr>
</table>
