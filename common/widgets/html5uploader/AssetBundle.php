<?php
namespace common\widgets\html5uploader;

use common\components\AssetBundle as BaseBundle;

/**
 * Class AssetBundle
 * @package common\widgets\html5uploader
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AssetBundle extends BaseBundle
{

    public $css = [
        'uploader.css',
    ];
    public $js = [
        'uploader.js',
    ];

    public $jsMin = [
        'uploader.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset'
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets";

        parent::init();

    }

}