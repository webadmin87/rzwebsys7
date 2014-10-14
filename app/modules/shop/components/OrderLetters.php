<?php
namespace app\modules\shop\components;

use Yii;
use yii\base\Component;
use \app\modules\shop\models\Status;
use \app\modules\shop\models\Order;

/**
 * Class OrderLetters
 * Компонент управления шаблонами уведомлений о заказах
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class OrderLetters extends Component
{

    /**
     * @var string путь к шаблонам
     */
    public $tplPath = "@webapp/modules/shop/letters";

    /**
     * Сохранение шаблона письма
     * @param Status $status статус
     * @return int
     */
    public function saveStatusTpl(Status $status)
    {

        $name = Yii::getAlias($this->tplPath . '/' . $status->getTplName());

        return file_put_contents($name, $status->tplHtml);

    }

    /**
     * Загрузка шаблона
     * @param Status $status статус
     */
    public function loadStatusTpl(Status $status)
    {
        $name = Yii::getAlias($this->tplPath . '/' . $status->getTplName());

        $status->tplHtml = file_get_contents($name);

    }

    /**
     * Рендер шаблона письма для клиента
     * @param Order $order заказ
     * @return string|null
     */
    public function renderStatusTpl(Order $order)
    {

        $status = $order->status;

        if($status) {

            $alias = $this->tplPath . '/' . $status->getTplName();

            return $this->renderTpl($order, $alias);

        }

        return null;

    }

    /**
     * Рендер шаблона письма для администратора сайта
     * @param Order $order заказа
     * @return string
     */
    public function renderAdminTpl(Order $order)
    {

        return $this->renderTpl($order, $this->tplPath . '/admin.php');

    }

    /**
     * Рендер шаблона письма
     * @param Order $order заказ
     * @param string $alias путь к шаблону
     * @return string
     */
    public function renderTpl(Order $order, $alias)
    {

        $view = Yii::$app->view;

        $goods = $view->render($this->tplPath . '/_order.php', ["order"=>$order]);

        $html = $view->render($alias, ["order"=>$order, "goods"=>$goods]);

        return $html;

    }

}