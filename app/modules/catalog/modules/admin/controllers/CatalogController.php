<?php

namespace app\modules\catalog\modules\admin\controllers;

use app\modules\catalog\models\Catalog;
use common\actions\crud;
use common\controllers\Admin;
use Yii;
use yii\filters\VerbFilter;

/**
 * CatalogController implements the CRUD actions for catalog model.
 */
class CatalogController extends Admin
{

    /**
     * @var string идентификатор файла перевода
     */

    public $tFile = "catalog/app";

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

        $class = catalog::className();

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