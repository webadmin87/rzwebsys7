<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
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
