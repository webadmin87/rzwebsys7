<?php
use app\modules\catalog\models;

return [

    'controllerMap' => [
        'migrate' => [
            'migrationLookup' => ['@webapp/modules/catalog/migrations'],
        ],
    ],

    'modules' => [

        'catalog' => [
            'class' => app\modules\catalog\Catalog::className(),
            'controllerNamespace' => 'app\modules\catalog\controllers',
            'modules' => [
                'admin' => [
                    'class' => app\modules\catalog\modules\admin\Admin::className(),
                    'controllerNamespace' => 'app\modules\catalog\modules\admin\controllers',
                    'menuItems' => function () {
                        return [
                            [
                                'label' => Yii::t('catalog/app', 'Catalog module'),
                                'items' => [
                                    ['label' => Yii::t('catalog/app', 'Catalogs'), 'url' => ['/admin/catalog/catalog'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\Catalog::className())]]],
                                    ['label' => Yii::t('catalog/app', 'Catalog Sections'), 'url' => ['/admin/catalog/catalog-section'],
                                        "permission" => ["listModels", ["model" => Yii::createObject(models\CatalogSection::className())]]],
									['label' => Yii::t('catalog/app', 'Producers'), 'url' => ['/admin/catalog/producer'],
										"permission" => ["listModels", ["model" => Yii::createObject(models\Producer::className())]]],
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

                'catalog/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/catalog/messages',
                    'fileMap' => [
                        'catalog/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [
                'catalog/<section:[A-z0-9_-]+>/<code:[A-z0-9_-]+>' => 'catalog/catalog/detail',
                'catalog/<section:[A-z0-9_-]+>' => 'catalog/catalog/index',
                'catalog' => 'catalog/catalog/index',
            ],

        ],

    ],

];