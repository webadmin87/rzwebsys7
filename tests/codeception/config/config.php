<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'homeUrl'=>['main/pages/index'],
    'components' => [
        'db' => [
            'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=rzwebsys7_advanced_tests',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
