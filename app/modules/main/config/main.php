<?php
use app\modules\main\models;

return [

    'controllerMap' => [
        'migrate' => [
            'migrationLookup' => ['@webapp/modules/main/migrations'],
        ],
    ],

    'modules' => [

        'main' => [
            'class' => app\modules\main\Main::className(),
            'controllerNamespace' => 'app\modules\main\controllers',
            'components' => [

				'config' => [
					'class'=>\app\modules\main\components\Config::className(),
				],

                'treeFinder' => [
                    'class'=>\common\components\TreeFinder::className(),
                ],

                'blocksProvider' => [
                    'class'=>\app\modules\main\components\BlocksProvider::className(),
                ],
            ],
            'modules' => [
                'admin' => [
                    'class' => app\modules\main\modules\admin\Admin::className(),
                    'controllerNamespace' => 'app\modules\main\modules\admin\controllers',
                    'menuItems' => function () {
                        return [
                            [
                                'label' => Yii::t('main/app', 'Main module'),
                                'items' => [
                                    ['label' => Yii::t('main/app', 'Pages'), 'url' => ['/admin/main/pages'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\Pages::className())]]],
                                    ['label' => Yii::t('main/app', 'Menu'), 'url' => ['/admin/main/menu'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\Menu::className())]]],
                                    ['label' => Yii::t('main/app', 'Users'), 'url' => ['/admin/main/user'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\User::className())]]],
                                    ['label' => Yii::t('main/app', 'FileManager'), 'url' => ['/admin/main/file-manager'],
                                        "permission" => ["fileManager",]],
                                    ['label' => Yii::t('main/app', 'Templates'), 'url' => ['/admin/main/template'],
                                        "permission" => ["rootAccess"]],
                                    ['label' => Yii::t('main/app', 'Includes'), 'url' => ['/admin/main/includes'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\Includes::className())]]],
                                    ['label' => Yii::t('main/app', 'Comments'), 'url' => ['/admin/main/comments'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\Comments::className())]]],
                                    ['label' => Yii::t('main/app', 'Tools'), 'url' => ['/admin/main/tools'],
                                        "permission" => ["rootAccess"]],
                                    ['label' => Yii::t('main/app', 'Permission'), 'url' => ['/admin/main/permission'],
                                        "permission" => ["rootAccess"]],
                                    ['label' => Yii::t('main/app', 'Config'), 'url' => ['/admin/main/config'],
                                        "permission" => ["rootAccess"]],
                                ]
                            ],
                        ];
                    },
                ]
            ],

        ],

    ],

    'components' => [

        'i18n' => [

            'translations' => [

                'main/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/main/messages',
                    'fileMap' => [
                        'main/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [

				['class' => '\app\modules\main\components\PageUrlRule'],
                //'page/<code:[A-z0-9_-]+>' => 'main/pages/index',

            ],

        ],

    ],

];