<?php
use \app\modules\news\models;
return [

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
                    'basePath' => '@app/modules/news/messages',
                    'fileMap' => [
                            'news/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules'=>[

               'news/<code:[A-z0-9_-]+>'=>'news/news/index',

            ],

        ],

    ],

];