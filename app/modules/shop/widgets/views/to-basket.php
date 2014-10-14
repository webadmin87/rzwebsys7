<?php
/**
 * @var \app\modules\shop\components\IShopItem $model модель товара
 */

use yii\helpers\Html;

$class = get_class($model);

?>
<div ng-controller="ToBasketCtrl" ng-cloak>

    <div class="input-group" shop-to-basket item-id="<?=$model->getId()?>" class-name="<?=$class?>">
        <?=Html::textInput("qty", null, ["ng-model"=>"qty", "class"=>"form-control"]);?>
        <span class="input-group-btn">
            <?=Html::button("{{label}}", ["class"=>"btn btn-default", "ng-click"=>"addToCart()"])?>
        </span>
    </div>

</div>