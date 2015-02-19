<?php

namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\IncludeGroup;
use common\controllers\Admin;
use yii\filters\VerbFilter;
use common\actions\crud;

/**
* IncludeGroupController implements the CRUD actions for IncludeGroup model.
*/
class IncludeGroupController extends Admin
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

        $class = IncludeGroup::className();

        return [

            'index'=>[
                'class'=>crud\Admin::className(),
                'modelClass'=>$class,
                'orderBy' => ['sort' => SORT_ASC],
            ],
            'create'=>[
                'class'=>crud\Create::className(),
                'modelClass'=>$class,
            ],
            'update'=>[
                'class'=>crud\Update::className(),
                'modelClass'=>$class,
            ],

            'view'=>[
                'class'=>crud\View::className(),
                'modelClass'=>$class,
            ],

            'delete'=>[
                'class'=>crud\Delete::className(),
                'modelClass'=>$class,
            ],

            'groupdelete'=>[
                'class'=>crud\GroupDelete::className(),
                'modelClass'=>$class,
            ],

            'editable'=>[
                'class'=>crud\XEditable::className(),
                'modelClass'=>$class,
            ],

        ];

    }

}