<?php
namespace app\modules\main\components;

use Yii;

/**
 * Trait BaseMailer
 * Трейт устанавливающий свойства для отправки писем
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
trait MailerTrait
{

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
     * Возвращает тему письма
     * @return string
     */

    public function getSubject()
    {

        if ($this->subject === null) {
            $this->subject = Yii::t('app/main', 'Email from site');
        }

        return $this->subject;
    }

    /**
     * @param string $val устанавливает тему письма
     */

    public function setSubject($val)
    {
        $this->subject = $val;
    }

    /**
     * Возвращает адрес получателя
     * @return string
     */

    public function getMailTo()
    {

        if ($this->_mailTo === null) {
            $this->_mailTo = Yii::$app->params["adminEmail"];
        }

        return $this->_mailTo;
    }

    /**
     * Устанавливает адрес получателя
     * @param string $val
     */

    public function setMailTo($val)
    {
        $this->_mailTo = $val;
    }

    /**
     * Возвращает адрес отправителя
     * @return string
     */

    public function getMailFrom()
    {

        if ($this->_mailFrom === null) {
            $this->_mailFrom = Yii::$app->params["mailFrom"];
        }

        return $this->_mailFrom;
    }

    /**
     * Устанавливает адрес отправителя
     * @param string $val
     */

    public function setMailFrom($val)
    {
        $this->_mailFrom = $val;
    }

}