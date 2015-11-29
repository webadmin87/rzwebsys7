<?php

namespace app\modules\main\controllers;

use yii\rest\Controller;
use app\modules\main\actions;
use app\modules\main\models\Review;
use app\modules\main\models\Comments;
use app\modules\main\models\FeedbackForm;

/**
 * Class CommentsController
 * Контроллер служебных операций
 * @package app\modules\main\controllers
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class ServiceController extends Controller
{

    /**
     * @inheritdoc
     */

    public function verbs()
    {
        return [

            'comment' => ['post'],
            'review' => ['post'],
            'feedback' => ['post'],

        ];
    }

    /**
     * @inheritdoc
     */

    public function actions()
    {

        return [

            'comment' => [
                'class' => actions\CommentAdd::className(),
                'modelClass' => Comments::className(),
            ],

	        'review' => [
		        'class' => actions\ReviewAdd::className(),
		        'modelClass' => Review::className(),
	        ],

	        'feedback' => [
		        'class' => actions\Feedback::className(),
		        'modelClass' => FeedbackForm::className(),
	        ],

        ];

    }

}