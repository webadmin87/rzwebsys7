<?php
/* @var $this yii\web\View */
/* @var $generator \app\gii\generators\appmodule\Generator */
echo "<?php\n";
?>
return [

    'modules' => [

        '<?=$generator->moduleID?>' => [
            'class' => '<?=$generator->moduleClass?>',
            'controllerNamespace' => '<?=$generator->controllerNamespace?>',
				'modules' => [
					'admin' => [
						'class' => '<?=$generator->adminModuleClass?>',
						'controllerNamespace' => '<?=$generator->adminControllerNamespace?>',
						'menuItems' => function () {
							return [
								[
									'label' => Yii::t('<?=$generator->moduleID?>/app', '<?=ucfirst($generator->moduleID)?> module'),
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

                '<?=$generator->moduleID?>/*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@webapp/modules/<?=$generator->moduleID?>/messages',
                    'fileMap' => [
                        '<?=$generator->moduleID?>/app' => 'app.php',
                    ],

                ],

            ],

        ],

        'urlManager' => [

            'rules' => [],

        ],

    ],

];