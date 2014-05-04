<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class Admin базовый класс контроллеров административного модуля
 */

class Admin extends Controller {

    public $layout = "@app/views/layouts/admin.php";

    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }


    /**
     * Возвращает меню админки
     * @return array
     */

    public function getMenuItems() {

        return [

            ['label' => Yii::t('core', 'Users'), 'url' => ['/admin/main/user']],

        ];

    }



}