<?php
namespace app\modules\main\actions\user;

use Yii;
use common\actions\crud\Base;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignUp
 * Действие регистрации пользователя
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class SignUp extends Base
{
	use \app\modules\main\components\MailerTrait;

	public $letter = "@app/modules/main/letters/sign-up.php";

	/**
	 * @var string имя класса модели
	 */
	public $modelClass = '\app\modules\main\models\User';

	/**
	 * @var array дефолтовые аттрибуты
	 */
	public $defaultAttrs = [
		'role' => 'user',
		'author_id' => 1,
	];

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

		if ($load && $request->post($this->validateParam)) {
			return $this->performAjaxValidation($model);
		}

		if ($load && $model->save()) {

			Yii::$app->user->login($model);

			$this->sendNotify($model, $request->post('password'));

			return $this->controller->redirect($this->returnUrl);

		} else {

			return $this->controller->render($this->tpl, [
				'model' => $model,
			]);

		}

	}

	protected function sendNotify($model, $password)
	{
		Yii::$app->mail->compose($this->letter, ["model" => $model, 'password' => $password])
			->setFrom($this->mailFrom)
			->setTo($model->email)
			->setSubject($this->subject)
			->send();
	}

}