<?php
namespace common\widgets\html5uploader;

use yii\web\AssetBundle as YiiBundle;

class AssetBundle extends YiiBundle {

    public $css = [
        'uploader.css',
    ];
    public $js = [
        'uploader.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\SortableAsset'
    ];

    public function init() {

        $this->sourcePath = __DIR__."/assets";

    }



}