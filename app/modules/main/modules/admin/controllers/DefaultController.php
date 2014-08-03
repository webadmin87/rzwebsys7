<?php
namespace app\modules\main\modules\admin\controllers;

use common\controllers\Admin;

/**
 * Class DefaultController
 * Контроллер шлавной страницы админки
 * @package app\modules\admin\controllers
 */
class DefaultController extends Admin
{

    public function actionIndex()
    {

        return $this->render('index');

    }

}