<?php
/**
 * @var \app\modules\main\models\FeedbackForm $model формы
 * @var array $formOptions настройки формы \yii\widgets\ActiveForm
 * @var string $id идентификатор виджета
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

echo Html::beginTag('div', ["id"=>$id]);

echo Html::tag('div', Yii::t('app/main', 'Message send'), ['class'=>'feedback-success alert alert-success', 'style'=>'display: none']);

echo Html::tag('div', Yii::t('app/main', 'Error during sending message'), ['class'=>'feedback-error alert alert-danger', 'style'=>'display: none']);

$form = ActiveForm::begin($formOptions);

echo $form->field($model, 'name');

echo $form->field($model, 'email');

echo $form->field($model, 'phone');

echo $form->field($model, 'text')->textarea();

echo Html::submitButton(Yii::t('app/main', 'Submit'), ["class"=>"btn btn-primary"]);

ActiveForm::end();

echo Html::endTag('div');