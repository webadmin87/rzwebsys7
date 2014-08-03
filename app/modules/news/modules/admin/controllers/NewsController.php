<?php

namespace app\modules\news\modules\admin\controllers;

use app\modules\news\models\News;
use common\actions\crud;
use common\controllers\Admin;
use Yii;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Admin
{

    /**
     * @var string идентификатор файла перевода
     */

    public $tFile = "news/app";

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {
        $beh = parent::behaviors();

        $beh['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
                'groupdelete' => ['post'],
            ],
        ];

        return $beh;
    }

    /**
     * Действия
     * @return array
     */
    public function actions()
    {

        $class = News::className();

        return [

            'index' => [
                'class' => crud\Admin::className(),
                'modelClass' => $class,
            ],
            'create' => [
                'class' => crud\Create::className(),
                'modelClass' => $class,
            ],
            'update' => [
                'class' => crud\Update::className(),
                'modelClass' => $class,
            ],

            'view' => [
                'class' => crud\View::className(),
                'modelClass' => $class,
            ],

            'delete' => [
                'class' => crud\Delete::className(),
                'modelClass' => $class,
            ],

            'groupdelete' => [
                'class' => crud\GroupDelete::className(),
                'modelClass' => $class,
            ],

            'editable' => [
                'class' => crud\XEditable::className(),
                'modelClass' => $class,
            ],

        ];

    }

}