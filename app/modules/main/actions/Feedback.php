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
class Feedback extends Action {

    /**
     * @var string кому отправлять
     */

    protected $_mailTo;

    /**
     * @var string от кого отправлять
     */

    protected $_mailFrom;

    /**
     * @var string тема письма
     */

    protected $subject;

    /**
     * @var string путь к шаблону письма
     */

    public $letter = "feedback";

    public function getSubject() {

        if($this->subject === null) {
            $this->subject = Yii::t('app/main', 'Email from site');
        }

        return $this->subject;
    }

    public function setSubject($val) {
        $this->subject = $val;
    }

    public function getMailTo() {

        if($this->_mailTo === null) {
            $this->_mailTo = Yii::$app->params["adminEmail"];
        }

        return $this->_mailTo;
    }

    public function setMailTo($val) {
        $this->_mailTo = $val;
    }

    public function getMailFrom() {

        if($this->_mailFrom === null) {
            $this->_mailFrom = Yii::$app->params["mailFrom"];
        }

        return $this->_mailFrom;
    }

    public function setMailFrom($val) {
        $this->_mailFrom = $val;
    }

    /**
     * Отправка сообщения обратной связи
     * @return object
     * @throws \yii\base\InvalidConfigException
     */

    public function run() {

        $class = $this->modelClass;

        $request = Yii::$app->request;

        $response = Yii::$app->getResponse();

        $model = Yii::createObject($class::className());

        $model->load($request->post());

        if($model->validate()) {

            $res = Yii::$app->mail->compose($this->letter, ["model"=>$model])
                ->setFrom($this->mailFrom)
                ->setTo($this->mailTo)
                ->setSubject($this->subject)
                ->send();

            if($res)
                $response->setStatusCode(201);

        }

        return $model;

    }


}