<?php
namespace app\modules\main\actions\user;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignUp
 * Действие регистрации пользователя
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class SignUp extends Action
{

	/**
	 * @var string имя класса модели
	 */
	public $modelClass = '\app\modules\main\models\User';

	/**
	 * @var int идентификатор автора для нового пользователя;
	 */
	public $defaultAuthorId = 1;

	/**
	 * @var string идентификатор автора для нового пользователя;
	 */
	public $defaultRole = \app\modules\main\models\User::ROLE_USER;

	/**
	 * @var array дефолтовые атрибуты
	 */
	public $defaultAttrs = [];

	/**
	 * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
	 */
	public $returnUrl = ['/user/profile/'];

	/**
	 * @var string сценарий для валидации
	 */
	public $modelScenario = 'insert';

	/**
	 * @var string шаблон
	 */
	public $tpl = "sign-up";

	/**
	 * @var array компоненты для уведомления пользователя
	 */
	public $notifiers = [
		'\app\modules\main\components\SignUpMailNotifier',
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

		$model = Yii::createObject(["class" => $class::className(), 'scenario' => $this->modelScenario]);

		$model->attributes = $this->defaultAttrs;

		$request = Yii::$app->request;

		$load = $model->load($request->post());

		$model->role = $this->defaultRole;
		$model->author_id = $this->defaultAuthorId;

		if ($load && $request->post($this->validateParam)) {
			return $this->performAjaxValidation($model);
		}

		if ($load && $model->save()) {

			Yii::$app->user->login($model);

			foreach ($this->notifiers as $notifierClass) {
				$notifier = Yii::CreateObject($notifierClass::className());
				$notifier->send($model, $request->post('User')['password']);
			}

			return $this->controller->redirect($this->returnUrl);

		} else {

			return $this->controller->render($this->tpl, [
				'model' => $model,
			]);

		}

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