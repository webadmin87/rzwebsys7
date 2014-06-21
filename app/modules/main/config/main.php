<?php
return [

    'modules' => [

        'main' => [
            'class'=>app\modules\main\Main::className(),
            'controllerNamespace' => 'app\modules\main\controllers',
            'modules'=> [
                'admin'=>[
                    'class'=>app\modules\main\modules\admin\Admin::className(),
                    'controllerNamespace' => 'app\modules\main\modules\admin\controllers',
                    'menuItems'=>function() { return [
                        [
                            'label'=>Yii::t('main/app', 'Main module'),
                            'items'=>[
                                ['label' => Yii::t('main/app', 'Pages'), 'url' => ['/admin/main/pages']],
                                ['label' => Yii::t('main/app', 'Menu'), 'url' => ['/admin/main/menu']],
                                ['label' => Yii::t('main/app', 'Users'), 'url' => ['/admin/main/user']],
                                ['label' => Yii::t('main/app', 'FileManager'), 'url' => ['/admin/main/file-manager']],
                                ['label' => Yii::t('main/app', 'Templates'), 'url' => ['/admin/main/template']],
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

                'main/*'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/modules/main/messages',
                    'fileMap' => [
                            'main/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules'=>[

                'page/<code:[A-z0-9_-]+>'=>'main/pages'

            ],

        ],

    ],

];