<?php
namespace app\modules\main\actions\user;

use Yii;
use yii\base\Action;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;

/**
 * Class Profile
 * Действие вывода профиля пользователя
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class Profile extends Action
{

	/**
	 * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
	 */
	public $returnUrl = ['/user/profile/'];

	/**
	 * @var string название параметра запроса, который служит признаком ajax валидации
	 */
	public $validateParam = "ajax";

	/**
	 * @var string шаблон
	 */
	public $tpl = "profile";

	public function run()
	{

		$model = Yii::$app->user->identity;

		if (!$model) {
			throw new NotFoundHttpException('Not found');
		}

		$modelRole = $model->role;
		$modelAuthorId = $model->author_id;

		$request = Yii::$app->request;

		$load = $model->load($request->post());

		$model->role = $modelRole;
		$model->author_id = $modelAuthorId;

		if ($load && $request->post($this->validateParam)) {
			return $this->performAjaxValidation($model);
		}

		if ($load && $model->save()) {
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