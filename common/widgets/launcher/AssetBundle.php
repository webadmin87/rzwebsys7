<?php
namespace common\widgets\launcher;

use common\components\AssetBundle as BaseBundle;

/**
 * Class AssetBundle
 * Ассет виджета
 * @package common\widgets\launcher
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AssetBundle extends BaseBundle
{

    public $js = [
        'starter.js',
        "init.js",
    ];

    public $jsMin = [
        'starter.min.js',
        "init.min.js",
    ];

    public $publishOptions = [
        "forceCopy" => true
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets";

        parent::init();

    }

}