<?php

namespace app\modules\catalog\modules\admin\controllers;

use app\modules\catalog\models\CatalogSection;
use common\actions\crud;
use common\controllers\Admin;
use Yii;
use yii\filters\VerbFilter;

/**
 * CatalogSectionController implements the CRUD actions for CatalogSection model.
 */
class CatalogSectionController extends Admin
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

        $class = CatalogSection::className();

        return [

            'index' => [
                'class' => crud\TAdmin::className(),
                'modelClass' => $class,
            ],
            'create' => [
                'class' => crud\TCreate::className(),
                'modelClass' => $class,
            ],
            'update' => [
                'class' => crud\TUpdate::className(),
                'modelClass' => $class,
            ],

            'view' => [
                'class' => crud\View::className(),
                'modelClass' => $class,
            ],

            'delete' => [
                'class' => crud\TDelete::className(),
                'modelClass' => $class,
            ],

            'groupdelete' => [
                'class' => crud\TGroupDelete::className(),
                'modelClass' => $class,
            ],

            'up' => [
                'class' => crud\TUp::className(),
                'modelClass' => $class,
            ],

            'down' => [
                'class' => crud\TDown::className(),
                'modelClass' => $class,
            ],

            'replace' => [
                'class' => crud\TReplace::className(),
                'modelClass' => $class,
            ],

            'editable' => [
                'class' => crud\XEditable::className(),
                'modelClass' => $class,
            ],

        ];

    }

}