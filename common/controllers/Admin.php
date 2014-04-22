<?php
use yii\web\Controller;

/**
 * Class Admin базовый класс контроллеров административного модуля
 */

class Admin extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => '*',
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => '*',
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }






}