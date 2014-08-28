<?php
use app\modules\banners\models;

return [

	'controllerMap' => [
		'migrate' => [
			'migrationLookup' => ['@webapp/modules/banners/migrations'],
		],
	],

    'modules' => [

        'banners' => [
            'class' => 'app\modules\banners\Banners',
            'controllerNamespace' => 'app\modules\banners\controllers',
				'modules' => [
					'admin' => [
						'class' => 'app\modules\banners\modules\admin\Admin',
						'controllerNamespace' => 'app\modules\banners\modules\admin\controllers',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('banners/app', 'Banners module'),
									'items' => [

										['label' => Yii::t('banners/app', 'Banners'), 'url' => ['/admin/banners/banner'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Banner::className())]]],

										['label' => Yii::t('banners/app', 'Places'), 'url' => ['/admin/banners/place'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Place::className())]]],

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

                'banners/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/banners/messages',
                    'fileMap' => [
                        'banners/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [],

        ],

    ],

];