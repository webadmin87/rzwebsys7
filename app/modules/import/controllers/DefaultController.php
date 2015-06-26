<?php

namespace app\modules\import\controllers;

use common\controllers\App;

class DefaultController extends App
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
