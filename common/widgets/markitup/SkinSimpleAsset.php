<?php
namespace common\widgets\markitup;

use yii\web\AssetBundle;

/**
 * Class SkinSimpleAsset
 * Ассет базового скина
 * @package common\widgets\markitup
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SkinSimpleAsset extends AssetBundle {

    public $css = [
        'style.css',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets/skins/simple";

    }

}