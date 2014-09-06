<?php
return [
    'controllerMap' => [
        'migrate' => [
            'class' => 'console\controllers\MigrateController'
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'rules' => [

                // Правила для админки

                'admin/<module:\w+>/<controller:[A-z0-9_-]+>/<action:[A-z0-9_-]+>/<id:\d+>' => '<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:[A-z0-9_-]+>/<action:[A-z0-9_-]+>' => '<module>/admin/<controller>/<action>',
                'admin/<module:\w+>/<controller:[A-z0-9_-]+>' => '<module>/admin/<controller>',
                'admin/<module:\w+>' => '<module>/admin',
                'admin' => 'main/admin',
            ]
        ],

        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
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

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'bbParser' => [
            "class" => \common\components\BBCodeParser::className()
        ],
        'resizer' => [
            "class" => \common\components\Resizer::className()
        ],
        'view' => [
            'class' => \common\components\View::className(),
        ],
    ],
];
