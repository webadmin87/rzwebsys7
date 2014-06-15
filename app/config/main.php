<?php

\Yii::$container->set(\yii\widgets\Pjax::className(), ["timeout" => false]);

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
    'controllerMap' => [
        'elfinder' => [
            'class' => mihaildev\elfinder\Controller::className(),
            'access' => ['root'],
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'path' => 'userfiles',
                    'name' => Yii::t('core', 'Userfiles'),
                ],

            ]
        ],
    ],
    'modules' => [

        'main' => [
            'class'=>app\modules\main\Main::className(),
            'controllerNamespace' => 'app\modules\main\controllers',
            'modules'=> ['admin'=>[
                'class'=>app\modules\main\modules\admin\Admin::className(),
                'controllerNamespace' => 'app\modules\main\modules\admin\controllers',
            ]],

        ],

    ],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix'=>'/',
            'rules'=>[

                // Правила для админки

                'admin/<module:\w+>/<controller:[A-z0-9_-]+>/<action:[A-z0-9_-]+>/<id:\d+>'=>'<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:[A-z0-9_-]+>/<action:[A-z0-9_-]+>'=>'<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:[A-z0-9_-]+>'=>'<module>/admin/<controller>',
                'admin/<module:\w+>'=>'<module>/admin',
                'admin'=>'main/admin',
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
