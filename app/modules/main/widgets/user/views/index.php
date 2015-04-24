<?php
/**
 * @var array signInRoute маршрут входа
 * @var array signOutRoute маршрут выхода
 * @var array signUpRoute маршрут регистрации
 * @var array viewRoute маршрут просмотра профиля
 * @var array updateRoute маршрут редактирования профиля
 */
use yii\helpers\Html;

if ( Yii::$app->user->isGuest ) {
	echo Html::a(Yii::t('main/app', 'User SignIn'), $signInRoute) .' | '. Html::a(Yii::t('main/app', 'User SignUp'), $signUpRoute);
} else {
	echo Yii::t('main/app', 'User SignIn As').' '.
		Html::a(Html::tag('strong', Yii::$app->user->identity->username), $viewRoute);
	echo Html::tag('br');
	echo Html::a(Yii::t('main/app', 'User Profile'), $updateRoute) .' | '. Html::a(Yii::t('main/app', 'User SignOut'), $signOutRoute, ['data' => ['method' => 'post']]);
}