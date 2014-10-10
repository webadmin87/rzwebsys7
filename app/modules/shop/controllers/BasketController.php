<?php
namespace app\modules\shop\controllers;

use common\controllers\App;

/**
 * Class BasketController
 * Контроллер корзины
 * @package app\modules\shop\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BasketController extends App
{

    /**
     * @var \app\modules\shop\components\Basket
     */
    protected $basket;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->basket = $this->module->basket;

        parent::init();

    }

    /**
     * Вывод страницы с содержимым заказа
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');


    }


    public function actionProcess()
    {

        $order = $this->basket->getOrder();

        return $this->render('process', ["order"=>$order]);

    }



}