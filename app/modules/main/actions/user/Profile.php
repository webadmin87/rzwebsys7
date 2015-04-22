<?php
namespace app\modules\main\actions\user;

use Yii;
use common\actions\crud\Base;

/**
 * Class Profile
 * Действие вывода профиля пользователя
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class Profile extends Base
{

	/**
	 * @var string имя класса модели
	 */
	public $modelClass = '\app\modules\main\models\User';

	/**
	 * @var array дефолтовые аттрибуты
	 */
	public $defaultAttrs = [];

	/**
	 * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
	 */
	public $returnUrl = ['/user/profile/'];

	/**
	 * @var string сценарий для валидации
	 */
	public $modelScenario = 'update';

	/**
	 * @var string шаблон
	 */
	public $tpl = "profile";

	public function run()
	{

		$model = Yii::$app->user->identity;

		$request = Yii::$app->request;

		$load = $model->load($request->post());

		if ($load && $request->post($this->validateParam)) {
			return $this->performAjaxValidation($model);
		}

		if ($load && $model->save()) {
			Yii::$app->user->login($model);
			return $this->controller->redirect($this->returnUrl);

		} else {

			return $this->controller->render($this->tpl, [
				'model' => $model,
			]);

		}

	}
}