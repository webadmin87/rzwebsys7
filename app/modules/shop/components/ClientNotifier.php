<?php
namespace app\modules\shop\components;

use Yii;
use yii\base\Component;
use app\modules\shop\models\Order;


/**
 * Class ClientNotifier
 * Компонент уведомления клиента о состоянии заказа
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ClientNotifier extends Component
{

    use \app\modules\main\components\MailerTrait;

    /**
     * @var string тема письма
     */
    public $subject = "Your order {number} on site {site}";

    /**
     * Отправка уведомления о заказа пользователю
     * @param Order $order заказ
     * @return bool
     */
    public function notify(Order $order)
    {

        $body =   Yii::$app->getModule('shop')->orderLetters->renderStatusTpl($order);

        $res = Yii::$app->mail->compose()
            ->setHtmlBody($body)
            ->setFrom($this->mailFrom)
            ->setTo($order->email)
            ->setSubject(Yii::t('shop/app', $this->subject, ["number"=>$order->id, "site"=>Yii::$app->getModule('main')->config->get('siteName')]))
            ->send();

        return $res;

    }

}