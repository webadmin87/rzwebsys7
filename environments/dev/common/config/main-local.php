<?php
return [
    'components' => [
        'db' => [
           'class' => 'yii\db\Connection',
			'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=rzwebsys7',
			'username' => 'postgres',
			'password' => 'xh48u56',
			'charset' => 'utf8',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
