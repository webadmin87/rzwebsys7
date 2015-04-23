<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \app\modules\main\models\LoginForm $model
 */

$this->title = Yii::t('main/app', 'User Forgot');
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

if(Yii::$app->session->hasFlash('password_changed'))
	echo Html::tag('div', Yii::t('main/app', 'Password Changed'), ['class' => 'feedback-success alert alert-success']);

$form = ActiveForm::begin([
	'enableAjaxValidation' => true,
]);

echo $form->field($model, 'username')->textInput();

echo $form->field($model, 'email')->textInput();

echo Html::submitButton(Yii::t('main/app', 'Submit'), ['class' => 'btn btn-primary']);

ActiveForm::end();