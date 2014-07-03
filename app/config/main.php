<?php

\Yii::$container->set(\yii\widgets\Pjax::className(), ["timeout" => false]);
\Yii::$container->set(\mcms\xeditable\XEditableAsset::className(), ["publishOptions" => ['forceCopy' => false]]);
\Yii::$container->set(\mcms\xeditable\XEditableColumn::className(), ['editable' => null]);

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app',
    'name'=>'RzWebSys7',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log'],
    'defaultRoute'=>'main/pages/index',
    'homeUrl'=>'/',
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
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/demo',
                    '@app/modules' => '@app/themes/demo/modules',
                ],
                'baseUrl' => '@web/themes/demo',
            ],
        ],
    ],
    'params' => $params,
];
