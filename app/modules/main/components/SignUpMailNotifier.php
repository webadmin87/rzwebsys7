<?php

namespace app\modules\main\components;

use Yii;
use yii\base\Object;

/**
 * Class SignUpMailNotifier
 * @package app\modules\main\components
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class SignUpMailNotifier extends Object {

	use \app\modules\main\components\MailerTrait;

	public $letter = "@app/modules/main/letters/sign-up.php";

	public function send($model, $password)
	{
		Yii::$app->mail->compose($this->letter, ["model" => $model, 'password' => $password])
			->setFrom($this->mailFrom)
			->setTo($model->email)
			->setSubject($this->subject)
			->send();
	}

}