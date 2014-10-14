<?php
namespace app\modules\shop\components;

use Yii;
use yii\base\Component;
use app\modules\shop\models\Order;


/**
 * Class AdminNotifier
 * Компонент уведомления администратора сайта о состоянии заказа
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AdminNotifier extends Component
{

    use \app\modules\main\components\MailerTrait;

    /**
     * @var string тема письма
     */
    public $subject = "New order {number} on site {site}";

    /**
     * Отправка уведомления о заказа админу
     * @param Order $order заказ
     * @return bool
     */
    public function notify(Order $order)
    {

        $body =   Yii::$app->getModule('shop')->orderLetters->renderAdminTpl($order);

        $res = Yii::$app->mail->compose()
            ->setHtmlBody($body)
            ->setFrom($this->mailFrom)
            ->setTo($this->mailTo)
            ->setSubject(Yii::t('shop/app', $this->subject, ["number"=>$order->id, "site"=>Yii::$app->getModule('main')->config->get('siteName')]))
            ->send();

        return $res;

    }

}