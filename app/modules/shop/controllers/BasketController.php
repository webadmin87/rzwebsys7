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
     * Вывод страницы с содержимым заказа
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');


    }



}