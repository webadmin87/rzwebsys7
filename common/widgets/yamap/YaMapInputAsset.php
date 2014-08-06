<?php

namespace common\widgets\yamap;

use common\components\AssetBundle;

/**
 * Class YaMapInput
 * Ассет виджета выбора координат
 * @package common\widgets\yamap
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapInputAsset extends AssetBundle
{

    public $js = [
        'yamap-input.js',
    ];

    public $jsMin = [
        'yamap-input.min.js',
    ];

    public $depends = [
		'common\components\uiboot\ThemeAsset',
		'yii\jui\DialogAsset',
		'common\widgets\yamap\YaMapApiAsset',
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets";

        parent::init();

    }

}