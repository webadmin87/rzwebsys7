<?php
use \app\modules\news\models;
return [

    'controllerMap'       => [
        'migrate' => [
            'migrationLookup' => ['@web/modules/news/migrations'],
        ],
    ],

    'modules' => [

        'news' => [
            'class'=>app\modules\news\News::className(),
            'controllerNamespace' => 'app\modules\news\controllers',
            'modules'=> [
                'admin'=>[
                    'class'=>app\modules\news\modules\admin\Admin::className(),
                    'controllerNamespace' => 'app\modules\news\modules\admin\controllers',
                    'menuItems'=>function() { return [
                        [
                            'label'=>Yii::t('news/app', 'News module'),
                            'items'=>[
                                ['label' => Yii::t('news/app', 'News'), 'url' => ['/admin/news/news'],
                                    "permission"=>["listModels", ["model"=>Yii::createObject(models\News::className())]]],
                                ['label' => Yii::t('news/app', 'News sections'), 'url' => ['/admin/news/news-section'],
                                    "permission"=>["listModels", ["model"=>Yii::createObject(models\NewsSection::className())]]],
                            ]
                        ],
                    ];},
                ]
            ],

        ],

    ],

    'components' => [

        'i18n'=>[

            'translations' => [

                'news/*'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@web/modules/news/messages',
                    'fileMap' => [
                            'news/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules'=>[
               'news/<section:[A-z0-9_-]+>/<code:[A-z0-9_-]+>'=>'news/news/detail',
               'news/<section:[A-z0-9_-]+>'=>'news/news/index',
               'news'=>'news/news/index',
            ],

        ],

    ],

];