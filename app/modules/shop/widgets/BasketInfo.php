<?php
namespace app\modules\shop\widgets;

use common\widgets\App;

/**
 * Class BasketInfo
 * Виджет вывода статистики корзины
 * @package app\modules\shop\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BasketInfo extends App
{

    /**
     * @var array url кнопки в корзину. может быть задан в виде маршрута
     */
    public $url = ['/shop/basket/index'];

    /**
     * @var string шаблон
     */
    public $tpl = "basket-info";


    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render($this->tpl, ["url"=>$this->url]);
    }


}