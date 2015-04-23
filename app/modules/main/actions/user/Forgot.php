<?php

namespace app\modules\main\actions\user;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class Forgot
 * @package app\modules\main\actions\user
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class Forgot extends Action {

	/**
	 * @var string имя класса модели
	 */
	public $modelClass = '\app\modules\main\models\ForgotForm';

	/**
	 * @var string шаблон
	 */
	public $tpl = 'forgot';

	/**
	 * @var array компоненты для уведомления пользователя
	 */
	public $notifiers = [
		'\app\modules\main\components\ForgotMailNotifier',
	];

	/**
	 * @var string название параметра запроса, который служит признаком ajax валидации
	 */
	public $validateParam = "ajax";

	public function run()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->controller->goHome();
		}

		$class = $this->modelClass;

		$model = Yii::createObject($class::className());

		$request = Yii::$app->request;

		$load = $model->load($request->post());

		if ($load && $request->post($this->validateParam)) {
			return $this->performAjaxValidation($model);
		}

		if ( $load && $password = $model->resetPassword() ) {

			foreach ($this->notifiers as $notifierClass) {
				$notifier = Yii::CreateObject($notifierClass::className());
				$notifier->send($model, $password);
			}

			Yii::$app->session->addFlash('password_changed');

//			$this->controller->refresh();

		}

		return $this->controller->render($this->tpl, [
			'model' => $model,
		]);
	}

	/**
	 * Ajax валидация модели
	 * @param \yii\db\ActiveRecord $model
	 * @return array
	 */
	protected function performAjaxValidation($model)
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		return ActiveForm::validate($model);
	}

}