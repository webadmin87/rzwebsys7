<?php
return [

	'modules' => [

		'geo' => [
			'class' => 'app\modules\geo\Geo',
			'controllerNamespace' => 'app\modules\geo\controllers',
		],

	],

	'components' => [

		'i18n' => [

			'translations' => [

				'geo/*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@webapp/modules/geo/messages',
					'fileMap' => [
						'geo/app' => 'app.php',
					],

				],

			],

		],


	],

];
