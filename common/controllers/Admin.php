<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class Admin базовый класс контроллеров административного модуля
 * @package common\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Admin extends Controller
{

    /**
     * @inheritdoc
     */

    public $enableCsrfValidation = false;

    /**
     * @var string идентификатор файла перевода
     */

    public $tFile = "core";

    /**
     * @inheritdoc
     */

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
                        'roles' => ['accessAdmin'],
                    ],
                ],
            ],
        ];
    }

}