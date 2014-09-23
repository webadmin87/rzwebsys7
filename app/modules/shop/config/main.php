<?php
return [

	'controllerMap' => [
		'migrate' => [
			'migrationLookup' => ['@webapp/modules/shop/migrations'],
		],
	],

    'modules' => [

        'shop' => [
            'class' => 'app\modules\shop\Shop',
            'controllerNamespace' => 'app\modules\shop\controllers',
				'modules' => [
					'admin' => [
						'class' => 'app\modules\shop\modules\admin\Admin',
						'controllerNamespace' => 'app\modules\shop\modules\admin\controllers',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('shop/app', 'Shop module'),
									'items' => []
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

                'shop/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/shop/messages',
                    'fileMap' => [
                        'shop/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [],

        ],

    ],

];