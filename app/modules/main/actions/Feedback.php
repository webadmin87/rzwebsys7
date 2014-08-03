<?php
namespace app\modules\main\actions;

use Yii;
use yii\rest\Action;

/**
 * Class Feedback
 * Обратная связь
 * @package app\modules\main\actions
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Feedback extends Action
{

    use \app\modules\main\components\MailerTrait;

    public $letter = "@app/modules/main/letters/feedback.php";

    /**
     * Отправка сообщения обратной связи
     * @return object
     * @throws \yii\base\InvalidConfigException
     */

    public function run()
    {

        $class = $this->modelClass;

        $request = Yii::$app->request;

        $response = Yii::$app->getResponse();

        $model = Yii::createObject($class::className());

        $load = $model->load($request->post());

        if ($load AND $model->validate()) {

            $res = Yii::$app->mail->compose($this->letter, ["model" => $model])
                ->setFrom($this->mailFrom)
                ->setTo($this->mailTo)
                ->setSubject($this->subject)
                ->send();

            if ($res)
                $response->setStatusCode(201);

        }

        return $model;

    }

}