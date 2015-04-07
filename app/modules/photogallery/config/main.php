<?php

use app\modules\photogallery\models;

return [

	'controllerMap' => [
		'migrate' => [
			'migrationLookup' => ['@webapp/modules/photogallery/migrations'],
		],
	],

    'modules' => [

        'photogallery' => [
            'class' => 'app\modules\photogallery\Photogallery',
            'controllerNamespace' => 'app\modules\photogallery\controllers',
				'modules' => [
					'admin' => [
						'class' => 'app\modules\photogallery\modules\admin\Admin',
						'controllerNamespace' => 'app\modules\photogallery\modules\admin\controllers',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('photogallery/app', 'Photogallery'),
                                    'icon' => 'glyphicon glyphicon-picture',
									'items' => [

                                        [
                                            'label' => Yii::t('photogallery/app', 'Galleries'), 'url' => ['/admin/photogallery/gallery'],
                                            "permission" => ["listModels", ["model" => Yii::createObject(models\Gallery::className())]]],
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

                'photogallery/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/photogallery/messages',
                    'fileMap' => [
                        'photogallery/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [

                'photogallery/<code:[A-z0-9_-]+>' => 'photogallery/gallery/detail',
                'photogallery' => 'photogallery/gallery/index',

            ],

        ],

    ],

];