<?php
/**
 * @var \app\modules\main\models\FeedbackForm $model формы
 * @var array $formOptions настройки формы \yii\widgets\ActiveForm
 */

use yii\widgets\ActiveForm;

$form = ActiveForm::begin($formOptions);

echo $form->field($model, 'name');

echo $form->field($model, 'email');

echo $form->field($model, 'phone');

echo $form->field($model, 'text')->textarea();

ActiveForm::end();