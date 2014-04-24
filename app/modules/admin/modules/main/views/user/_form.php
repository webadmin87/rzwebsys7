<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\modules\main\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>'true']); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'role')->dropDownList($model->getRolesNames()) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->textInput() ?>

    <?= $form->field($model, 'confirm_password')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= Html::hiddenInput('apply', 0) ?>

    <?= Html::hiddenInput('returnUrl', Yii::$app->request->post('returnUrl', Yii::$app->request->referrer)) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' =>'btn btn-success']) ?>
        <?= Html::submitButton('Apply', ['class' =>'btn btn-primary', 'onClick'=>'$("input[name=\'apply\']").val(1)']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
