<?php
/**
 * @var \app\modules\main\models\ForgotForm $model модель пользователя
 * @var string $password
 */

use yii\helpers\Html;

echo Html::tag('p', Yii::t('main/app', 'User Forgot Letter Header'));

echo Html::tag('p', Html::tag('strong', Yii::t('main/app', 'Username').': ').$model->username);

echo Html::tag('p', Html::tag('strong', Yii::t('main/app', 'New Password').': ').$password);