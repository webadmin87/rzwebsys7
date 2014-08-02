<?php

namespace app\modules\main\modules\admin\controllers;

use Yii;
use app\modules\main\models\Template;
use common\controllers\Root;
use yii\filters\VerbFilter;
use common\actions\crud;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Root
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
    public function actions() {

        $class = Template::className();

        return [

            'index'=>[
                'class'=>crud\Admin::className(),
                'modelClass'=>$class,
                'orderBy'=>['sort'=>SORT_ASC],
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