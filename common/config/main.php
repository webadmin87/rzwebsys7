<?php
return [
    'controllerMap'       => [
        'migrate' => [
            'class' => 'console\controllers\MigrateController'
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [

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
        'bbParser'=>[
            "class" => \common\components\BBCodeParser::className()
        ],
        'resizer'=>[
            "class" => \common\components\Resizer::className()
        ],
        'view'=>[
            'class' => \common\components\View::className(),
        ],
    ],
];
