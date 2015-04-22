<?php
/**
 * @var array signIn массив параметров регистрации
 */
use yii\helpers\Html;

if ( Yii::$app->user->isGuest ) {
	echo Html::a(Yii::t('main/app', 'User SignIn'), $signInRoute) .' | '. Html::a(Yii::t('main/app', 'User SignUp'), $signUpRoute);
} else {
	echo Yii::t('main/app', 'User SignIn As').' '.Html::tag('strong', Yii::$app->user->identity->username);
	echo Html::tag('br');
	echo Html::a(Yii::t('main/app', 'User Profile'), $profileRoute) .' | '. Html::a(Yii::t('main/app', 'User SignOut'), $signOutRoute);
}