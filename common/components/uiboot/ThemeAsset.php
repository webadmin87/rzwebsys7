<?php

namespace common\components\uiboot;

use yii\web\AssetBundle;

/**
 * Class ThemeAsset
 * Тема jQuery UI под bootstrap
 * @package common\components\uiboot
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ThemeAsset extends AssetBundle
{
	public $sourcePath = '@common/components/uiboot/assets';
	public $css = [
		'theme/jquery.ui.css',
	];
}
