<?php

namespace app\modules\main\controllers;

use Yii;
use common\controllers\App;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class UserController
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class UserController extends App {

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'rules' => [
				[
					'actions' => ['sign-in', 'sign-up', 'forgot', 'error'],
					'allow' => true,
				],
				[
					'actions' => ['sign-out', 'update', 'view'],
					'allow' => true,
					'roles' => ['@'],
				],
			],
		];

		$behaviors['verbs'] = [
			'class' => VerbFilter::className(),
			'actions' => [
				'sign-out' => ['post'],
			],
		];

		return $behaviors;
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'sign-in' => [
				'class' => '\app\modules\main\actions\user\SignIn',
			],
			'sign-up' => [
				'class' => '\app\modules\main\actions\user\SignUp',
			],
			'view' => [
				'class' => '\app\modules\main\actions\user\View',
			],
			'update' => [
				'class' => '\app\modules\main\actions\user\Update',
			],
			'forgot' => [
				'class' => '\app\modules\main\actions\user\Forgot',
			]
		];
	}

	/**
	 * Выход
	 * @return \yii\web\Response
	 */
	public function actionSignOut()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

}