<?php
/**
 * @var \app\modules\shop\models\Order $order модель заказа
 * @var array $deliveries массив способов доставки id=>title
 * @var array $payments массив способов оплаты id=>title
 * @var \yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;


$form = \yii\widgets\ActiveForm::begin(["options" => ["name" => "client", "novalidate" => true], "enableClientValidation" => false, "enableAjaxValidation" => false]);

$validator = Yii::createObject('\yii\validators\EmailValidator');

?>

	<div class="row clearfix">

		<div class="col-sm-6">

			<?php
			echo $form->field($order, "name", ["hintOptions" => ["ng-show" => "client['Order[name]'].\$dirty && client['Order[name]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->textInput(["ng-model" => "order.name", "required" => true]);

			echo $form->field($order, "email", ["hintOptions" => ["ng-show" => "client['Order[email]'].\$dirty && client['Order[email]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->input("email", ["ng-model" => "order.email", "required" => true, "ng-pattern"=>$validator->pattern]);

			echo $form->field($order, "phone", ["hintOptions" => ["ng-show" => "client['Order[phone]'].\$dirty && client['Order[phone]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->textInput(["ng-model" => "order.phone"]);

			echo $form->field($order, "city", ["hintOptions" => ["ng-show" => "client['Order[city]'].\$dirty && client['Order[city]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->textInput(["ng-model" => "order.city", "required" => true]);


			echo $form->field($order, "comment")->textarea(["ng-model" => "order.comment"]);

			?>
		</div>
		<div class="col-sm-6">
			<?php
			echo $form->field($order, "index")->textInput(["ng-model" => "order.index"]);

			echo $form->field($order, "address", ["hintOptions" => ["ng-show" => "client['Order[address]'].\$dirty && client['Order[address]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->textInput(["ng-model" => "order.address", "required" => true]);

            echo $form->field($order, "delivery_id", ["hintOptions" => ["ng-show" => "client['Order[delivery_id]'].\$dirty && client['Order[delivery_id]'].\$invalid"]])
                ->hint("{{messages.fieldError}}")
                ->dropDownList([], ["ng-options"=>"value.id as value.title for value in deliveries", "ng-model" => "order.delivery_id", "ng-change"=>"shopBasket.syncOrder()", "required" => true]);

			?>
			<div class="alert alert-info" ng-show="deliveryDescription">{{deliveryDescription}}</div>
			<?php
			echo $form->field($order, "payment_id", ["hintOptions" => ["ng-show" => "client['Order[payment_id]'].\$dirty && client['Order[payment_id]'].\$invalid"]])
				->hint("{{messages.fieldError}}")
				->dropDownList([], ["ng-options"=>"value.id as value.title for value in payments", "ng-model" => "order.payment_id", "ng-change"=>"shopBasket.syncOrder()", "required" => true]);

			?>
			<div class="alert alert-info" ng-show="paymentDescription">{{paymentDescription}}</div>

		</div>
	</div>

<?php

echo Html::button(Yii::t('shop/app', 'Confirm order'), ["ng-disabled" => "!client.\$valid || order.allGoods.length==0", "ng-click"=>"ctrl.confirmOrder()", "class" => "btn btn-primary"]);

$form->end();