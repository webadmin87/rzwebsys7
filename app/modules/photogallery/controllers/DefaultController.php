<?php

namespace app\modules\photogallery\controllers;

use common\controllers\App;

class DefaultController extends App
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
