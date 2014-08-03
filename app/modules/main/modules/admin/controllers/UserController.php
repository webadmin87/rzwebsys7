<?php

namespace app\modules\main\modules\admin\controllers;

use app\modules\main\models\User;
use common\actions\crud;
use common\controllers\Admin;
use Yii;
use yii\filters\VerbFilter;

/**
 * Class UserController
 * Контроллер CRUD действий для моделей пользователей системы
 * @package app\modules\admin\modules\main\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class UserController extends Admin
{

    /**
     * @var string идентификатор файла перевода
     */

    public $tFile = "main/app";

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

        $class = User::className();

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
