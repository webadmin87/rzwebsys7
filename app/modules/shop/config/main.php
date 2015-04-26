<?php
use app\modules\shop\models;
return [

	'controllerMap' => [
		'migrate' => [
			'migrationLookup' => ['@webapp/modules/shop/migrations'],
		],
	],

    'modules' => [

        'shop' => [
            'class' => 'app\modules\shop\Shop',
			'modelClasses'=>['app\modules\catalog\models\Catalog'],
			'components'=>[
				'orderLetters'=>\app\modules\shop\components\OrderLetters::className(),
				'clientNotifier'=>\app\modules\shop\components\ClientNotifier::className(),
				'adminNotifier'=>\app\modules\shop\components\AdminNotifier::className(),
				'basket'=>[
					'class'=>\app\modules\shop\components\Basket::className(),
					'components'=> [
						'orderManager' => [
							'class'=>\app\modules\shop\components\OrderManager::className(),
						],
					]
				],
			],
            'controllerNamespace' => 'app\modules\shop\controllers',
				'modules' => [
					'admin' => [
						'class' => 'app\modules\shop\modules\admin\Admin',
						'controllerNamespace' => 'app\modules\shop\modules\admin\controllers',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('shop/app', 'Shop module'),
                                    'icon' => 'glyphicon glyphicon-shopping-cart',
									'items' => [

										['label' => Yii::t('shop/app', 'Orders'), 'url' => ['/admin/shop/order'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Order::className())]]],

										['label' => Yii::t('shop/app', 'Goods'), 'url' => ['/admin/shop/good'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Good::className())]]],

										['label' => Yii::t('shop/app', 'Statuses'), 'url' => ['/admin/shop/status'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Status::className())]]],

										['label' => Yii::t('shop/app', 'Payments'), 'url' => ['/admin/shop/payment'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Payment::className())]]],

										['label' => Yii::t('shop/app', 'Deliveries'), 'url' => ['/admin/shop/delivery'],
											"permission" => ["listModels", ["model" => Yii::createObject(models\Delivery::className())]]],
									],
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