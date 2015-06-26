<?php
return [

    'modules' => [

        'import' => [
            'class' => 'app\modules\import\Import',
            'components'=>[
                'csvImporter'=>[
                    'class'=>\app\modules\import\components\CsvImporter::className(),
                    'allowedModels'=>[
                        \app\modules\main\models\User::className(),                    ],
                    ],
            ],
            'controllerNamespace' => 'app\modules\import\controllers',
				'modules' => [
					'admin' => [
						'class' => 'app\modules\import\modules\admin\Admin',
						'controllerNamespace' => 'app\modules\import\modules\admin\controllers',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('import/app', 'Import module'),
                                    'icon' => 'glyphicon glyphicon-import',
									'items' => [
                                        ['label' => Yii::t('import/app', 'Csv import'), 'url' => ['/admin/import/csv-import'],
                                            "permission" => ["rootAccess"],
                                        ]
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

                'import/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/import/messages',
                    'fileMap' => [
                        'import/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [],

        ],

    ],

];