<table class="table table-striped" ng-show="order.allGoods.length>0">
    <tr><th><?=Yii::t('shop/app', 'Title')?></th><th><?=Yii::t('shop/app', 'Qty')?></th><th><?=Yii::t('shop/app', 'Price')?></th><th><?=Yii::t('shop/app', 'Total price')?></th><th></th></tr>
    <tr ng-repeat="model in order.allGoods">
        <td><a href="{{model.link}}">{{model.title}}</a></td>
        <td><div class="col-sm-4"><input ng-disabled="readOnly" type="text" class="form-control" ng-model="model.qty" ng-change="ctrl.update(model)" /></div></td>
        <td>{{model.finalPrice | currency}}</td><td>{{model.finalPrice*model.qty | currency}}</td>
        <td><button class="btn btn-danger" ng-click="ctrl.del(model)" ng-disabled="readOnly"><?=Yii::t('core', 'Delete')?></button></td>
    </tr>
    <tr ng-show="order.delivery_price"><td colspan="5"><?=Yii::t('shop/app', 'Delivery price')?>: {{order.delivery_price | currency}}</td></tr>
    <tr class="warning"><td colspan="5"><?=Yii::t('shop/app', 'Total price')?>: {{order.totalPrice | currency}}</td></tr>
</table>

<div class="alert alert-info" ng-show="order.allGoods.length==0">
    <?=Yii::t('shop/app', 'Your basket is empty')?>
</div>