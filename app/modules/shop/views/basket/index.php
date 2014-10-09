<h1><?=Yii::t('shop/app', 'Basket')?></h1>
<div ng-controller="OrderListCtrl as ctrl">
    <table class="table">
        <tr><th><?=Yii::t('shop/app', 'Title')?></th><th><?=Yii::t('shop/app', 'Qty')?></th><th><?=Yii::t('shop/app', 'Price')?></th><th><?=Yii::t('shop/app', 'Total price')?></th><th></th></tr>
        <tr ng-repeat="model in order.allGoods">
            <td>{{model.title}}</td><td><input type="text" class="form-control" ng-model="model.qty" ng-change="ctrl.update(model)" /></td><td>{{model.price | currency}}</td><td>{{model.price*model.qty | currency}}</td><td><button class="btn btn-danger" ng-click="ctrl.del(model)"><?=Yii::t('core', 'Delete')?></button></td>
        </tr>
        <tr><td colspan="5"><?=Yii::t('shop/app', 'Total price')?>: {{order.totalPrice | currency}}</td></tr>
    </table>

</div>