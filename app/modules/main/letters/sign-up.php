<?php
/**
 * @var \app\modules\main\models\User $model модель пользователя
 * @var string $password
 */

use yii\helpers\Html;

$attrs = [
    'username' => $model->username,
    'password' => $password,
    'email' => $model->email,
    'name' => $model->name,
];

echo Html::tag('p', Yii::t('main/app', 'User SignUp Letter Header'));

foreach ($attrs as $k => $v) {
    echo Html::beginTag('p');
    echo Html::tag('strong', $model->getAttributeLabel($k).': ');
    echo $v;
    echo Html::endTag('p');
}