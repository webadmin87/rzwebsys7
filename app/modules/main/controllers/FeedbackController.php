<?php

namespace app\modules\main\controllers;

use yii\rest\Controller;

/**
 * Class FeedbackController
 * Контроллер обратной связи
 * @package app\modules\main\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class FeedbackController extends Controller {


    /**
     * @inheritdoc
     */

    public function verbs()
    {
        return [

              'send'  => ['post'],

        ];
    }

    /**
     * @inheritdoc
     */

    public function actions() {

       return [

           "send"=>[
               "class"=>\app\modules\main\actions\Feedback::className(),
               "modelClass"=>\app\modules\main\models\FeedbackForm::className(),
           ],

       ];

   }

}