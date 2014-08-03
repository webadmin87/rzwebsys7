<?php
namespace app\modules\main\modules\admin\controllers;

use common\controllers\Admin;
use Yii;

/**
 * Class UploadController
 * Контроллер загрузки файлов
 * @package app\modules\admin\controllers
 */
class UploadController extends Admin
{

    /**
     * @inheritdoc
     * Отключаем csrf валидацию
     */

    public function beforeAction($action)
    {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);

    }

    /**
     * @inheritdoc
     */

    public function actions()
    {

        return [

            "index" => [
                "class" => \common\actions\Upload::className(),
            ]

        ];

    }

}