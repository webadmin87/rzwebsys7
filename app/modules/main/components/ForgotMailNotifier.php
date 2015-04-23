<?php

namespace app\modules\main\components;

use Yii;
use yii\base\Object;

/**
 * Class ForgotMailNotifier
 * @package app\modules\main\components
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ForgotMailNotifier extends Object {

	use \app\modules\main\components\MailerTrait;

	/**
	 * @var сообщение для темы письма
	 */
	public $subjectMessage = 'User Forgot Letter Subject';

	/**
	 * @var string шаблон письма
	 */
	public $letter = "@app/modules/main/letters/forgot.php";

	public function send($model, $password)
	{

		Yii::$app->mail->compose($this->letter, ["model" => $model, 'password' => $password])
			->setFrom($this->mailFrom)
			->setTo($model->email)
			->setSubject( Yii::t('main/app', $this->subjectMessage))
			->send();
	}

}