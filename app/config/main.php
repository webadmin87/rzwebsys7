<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app',
    'name' => 'RzWebSys7',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'main/pages/index',
    'homeUrl' => '/',
    'controllerMap' => [
        'elfinder' => [
            'class' => mihaildev\elfinder\Controller::className(),
            'access' => ['fileManager'],
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
					'baseUrl'=>'@web',
					'basePath'=>'@webroot',
                    'path' => 'userfiles',
                    'name' => Yii::t('core', 'Userfiles'),
                ],

            ]
        ],
    ],
    'components' => [

		'request' => [
			'enableCookieValidation' => true,
		],

        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => ['jquery.min.js']
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
