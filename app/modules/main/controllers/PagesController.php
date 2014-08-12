<?php

namespace app\modules\main\controllers;

use app\modules\main\models\Pages;
use common\controllers\App;
use yii\web\NotFoundHttpException;

/**
 * Class PagesController
 * Контроллер отображения текстовых страниц
 * @package app\modules\main\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PagesController extends App
{

    const INDEX_CODE = "main";

    /**
     * Отображение текстовой страницы
     * @param string $code символьный код страницы
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionIndex($code = self::INDEX_CODE)
    {

        $model = Pages::find()->published()->where(["code" => $code])->one();

        if (!$model)
            throw new NotFoundHttpException;

        if ($model->code != self::INDEX_CODE)
            $this->view->breadCrumbs = $model->getBreadCrumbsItems($model->id, function ($model) {
                return ['/main/pages/index', 'model' => $model];
            });

        $this->view->registerMetaTags($model);

        return $this->render('index', ["model" => $model]);

    }

}