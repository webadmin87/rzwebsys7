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
	 * @var array маршрут выхода
	 */
	public $signOutRoute = ['/main/user/sign-out'];

	/**
	 * @var array маршрут регистрации
	 */
	public $signUpRoute = ['/main/user/sign-up'];

	/**
	 * @var array маршрут просмотра профиля
	 */
	public $viewRoute = ['/main/user/view/'];

	/**
	 * @var array маршрут редактирования профиля
	 */
	public $updateRoute = ['/main/user/update/'];

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
			'viewRoute' => $this->viewRoute,
			'updateRoute' => $this->updateRoute,
		]);
	}
}
