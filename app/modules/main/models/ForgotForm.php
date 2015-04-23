<?php

namespace app\modules\main\models;

use Yii;
use yii\base\Model;

/**
 * Class ForgotForm
 * @package app\modules\main\models
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ForgotForm extends Model{

	public $username;

	public $email;

	public $passwordLength = 6;

	private $_user = false;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'email'], 'required'],
			[['email'], 'email'],
			[['username'], 'validateUser'],
		];
	}

	/**
	 * @inheritdoc
	 */

	public function attributeLabels()
	{
		return [
			"username" => Yii::t('main/app', 'Username'),
			"email" => Yii::t('main/app', 'Email'),
		];
	}

	/**
	 * Finds user by [[username, email]]
	 * @return User|null
	 */
	public function getUser()
	{
		if ($this->_user === false) {
			$this->_user = User::findOne(['username' => $this->username, 'email' => $this->email, 'active' => true]);
			if ($this->_user) {
				$this->_user->verifyCode = User::VERIFY_CODE;
			}
		}

		return $this->_user;
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validateUser()
	{
		if (!$this->hasErrors()) {
			$user = $this->getUser();
			if (!$user) {
				$this->addError('email', Yii::t('main/app', 'User Forgot Not Found'));
			}
		}
	}

	/**
	 * @return string|bool генерация пароля пользователя
	 */
	public function resetPassword()
	{

		if ( $this->validate() ) {

			$newPassword = Yii::$app->getSecurity()->generateRandomString($this->passwordLength);
			$user = $this->getUser();
			$user->setPassword($newPassword);

			if ($user->save()) {
				return $newPassword;
			}

		}

		return false;
	}

}