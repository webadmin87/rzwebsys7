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

    protected $_subject;

    /**
     * Возвращает тему письма
     * @return string
     */

    public function getSubject()
    {

        if ($this->_subject === null) {
            $this->_subject = Yii::t('main/app', 'Email from site');
        }

        return $this->_subject;
    }

    /**
     * @param string $val устанавливает тему письма
     */

    public function setSubject($val)
    {
        $this->_subject = $val;
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