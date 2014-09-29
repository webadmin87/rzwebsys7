<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '192.168.56.1'],
        'generators'=>[
			'appmodule'=>[
				'class'=>\app\gii\generators\appmodule\Generator::className(),
			],
            'crud'=>[
                'class' => 'yii\gii\generators\crud\Generator',
                "templates"=>[
                    'App CRUD'=>'@app/views/gii/crud/app',
                    'App tree CRUD'=>'@app/views/gii/crud/app-tree',
                ],

            ],

        ],
    ];

}

return $config;
