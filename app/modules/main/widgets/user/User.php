<?php
namespace app\modules\main\widgets\user;

use common\widgets\App;

/**
 * Class User
 * Виджет формы авторизации
 * @package app\modules\main\widgets\user
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class User extends App
{

	/**
	 * @var array маршрут отправки формы авторизации
	 */
	public $signInRoute = ['/main/user/sign-in'];

	/**
	 * @var string класс модели формы авторизации
	 */
	public $signInForm = '\app\modules\main\models\SignInForm';

	/**
	 * @var array параметры формы авторизации \yii\widgets\ActiveForm
	 */
	public $signInFormOptions = [];

	/**
	 * @var array маршрут выхода
	 */
	public $signOutRoute = ['/main/user/sign-out'];

	/**
	 * @var array маршрут регистрации
	 */
	public $signUpRoute = ['/main/user/sign-up'];

	/**
	 * @var array маршрут профиля
	 */
	public $profileRoute = ['/main/user/profile/'];

	/**
	 * @var string селектор для ссылки по которой открывать виджет обратной связи в fancybox. Если не задан форма выводится на странице
	 */
	public $signInfancySelector;


	public function run()
	{
		return $this->render($this->tpl, [
			'signInRoute' => $this->signInRoute,
			'signOutRoute' => $this->signOutRoute,
			'signUpRoute' => $this->signUpRoute,
			'profileRoute' => $this->profileRoute,
		]);
	}
}
