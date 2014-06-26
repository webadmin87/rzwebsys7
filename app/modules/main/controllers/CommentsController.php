<?php

namespace app\modules\main\controllers;

use yii\rest\Controller;

/**
 * Class CommentsController
 * Контроллер комментариев
 * @package app\modules\main\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CommentsController extends Controller {

    /**
     * @var string имя класса модели
     */

    public $modelClass = "\\app\\modules\\main\\models\\Comments";

    /**
     * @inheritdoc
     */

    public function verbs()
    {
        return [

              'add'  => ['post'],

        ];
    }

    /**
     * @inheritdoc
     */

    public function actions() {

       return [

           "add"=>[
               "class"=>\app\modules\main\actions\CommentAdd::className(),
               "modelClass"=>$this->modelClass,
           ],

       ];

   }

}