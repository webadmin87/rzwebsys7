<?php
namespace common\widgets\html5uploader;

use yii\web\AssetBundle as YiiBundle;

class AssetBundle extends YiiBundle {

    public $css = [
        'assets/uploader.css',
    ];
    public $js = [
        'assets/uploader.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\SortableAsset'
    ];

    public function init() {

        $this->sourcePath = __DIR__;

    }



}