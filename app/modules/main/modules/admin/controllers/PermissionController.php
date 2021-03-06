<?php

namespace app\modules\main\modules\admin\controllers;

use app\modules\main\models\Permission;
use common\actions\crud;
use common\controllers\Root;
use Yii;
use yii\filters\VerbFilter;

/**
 * PermissionController implements the CRUD actions for Permission model.
 */
class PermissionController extends Root
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

        $class = Permission::className();

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