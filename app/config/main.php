<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log'],
    'modules' => [

        'admin' => [
            'class'=>app\modules\admin\Admin::className(),
            'modules'=> ['main'=>[
                'class'=>app\modules\admin\modules\main\Main::className()
            ]],

        ],

        'main' => [
            'class'=>app\modules\main\Main::className(),
        ],

    ],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[

            ]
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en',
                    'fileMap' => [
                        'core' => 'core.php',
                    ],
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\modules\main\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
