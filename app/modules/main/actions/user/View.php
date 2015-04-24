<?php
namespace app\modules\main\actions\user;

use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;

/**
 * Class View
 * Действие вывода профиля пользователя
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class View extends Action
{

	/**
	 * @var string шаблон
	 */
	public $tpl = "view";

	public function run()
	{

		$model = Yii::$app->user->identity;

		if (!$model) {
			throw new NotFoundHttpException('Not found');
		}

		return $this->controller->render($this->tpl, [
			'model' => $model,
		]);

	}

}