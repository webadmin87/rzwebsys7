<?php
namespace app\modules\shop\widgets;

use common\widgets\App;

/**
 * Class ToBasket
 * Виджет добавления товаров в корзину
 * @package app\modules\shop\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ToBasket extends App
{

    /**
     * @var \app\modules\shop\components\IShopItem модель товара
     */
    public $model;

    /**
     * @var string шаблон
     */
    public $tpl = "to-basket";

    /**
     * @inheritdoc
     */
    public function run()
    {

        return $this->render($this->tpl, ["model"=>$this->model]);

    }

}