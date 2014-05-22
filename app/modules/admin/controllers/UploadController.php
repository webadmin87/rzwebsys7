<?php
namespace app\modules\admin\controllers;
use Yii;
use common\controllers\Admin;

/**
 * Class UploadController
 * Контроллер загрузки файлов
 * @package app\modules\admin\controllers
 */

class UploadController extends Admin {

    /**
     * @inheritdoc
     * Отключаем csrf валидацию
     */

    public function beforeAction($action) {

        Yii::$app->request->enableCsrfValidation = false;

        return parent::beforeAction($action);

    }

    /**
     * @inheritdoc
     */

    public function actions() {

        return [

            "index"=>[
                "class" => \common\actions\Upload::className(),
            ]

        ];

    }


}