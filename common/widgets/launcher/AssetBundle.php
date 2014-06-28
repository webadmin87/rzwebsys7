<?php
namespace common\widgets\launcher;

use yii\web\AssetBundle as YiiBundle;

/**
 * Class AssetBundle
 * Ассет виджета
 * @package common\widgets\launcher
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AssetBundle extends YiiBundle {

    public $js = [
        'starter.js',
        "init.js",
    ];

    public $publishOptions = [
        "forceCopy"=>true
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets";

    }



}