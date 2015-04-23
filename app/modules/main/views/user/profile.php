<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\components\View $this
 * @var \app\modules\main\models\User $model модель пользователя
 */

$this->title = Yii::t('main/app', 'User Profile');
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title.' '.$model->username);

$form = ActiveForm::begin([
	'enableAjaxValidation' => true,
]);

echo $form->field($model, 'username')->textInput();

echo $form->field($model, 'password')->passwordInput();

echo $form->field($model, 'confirm_password')->passwordInput();

echo $form->field($model, 'email')->textInput();

echo $form->field($model, 'name')->textInput();

echo Html::submitButton('Отправить', ['class' => 'btn btn-primary']);

ActiveForm::end();