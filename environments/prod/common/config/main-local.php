<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
			'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=rzwebsys7',
			'username' => 'rzwebsys7',
			'password' => 'password',
			'charset' => 'utf8',
            'enableSchemaCache'=>true,
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'urlManager'=>[
            'baseUrl'=>'http://rzwebsys7.dev',
        ],
    ],
];
